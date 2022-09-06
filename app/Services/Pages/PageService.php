<?php

namespace App\Services\Pages;

use App\Entities\DataTransferObjects\Pages\ContentTableDTO;
use App\Entities\DataTransferObjects\Pages\PageContentDTO;
use App\Exceptions\BusinessLogicException;
use App\Helpers\FileHelper;
use App\Models\Page;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Log;
use PHPHtmlParser\Dom;
use PHPHtmlParser\Dom\Node\InnerNode;
use PHPHtmlParser\Dom\Tag;
use Storage;
use Throwable;

class PageService
{
    /**
     * @param array $data
     * @param string|null $content
     * @return Page|null
     * @throws Throwable
     */
    public function create(array $data, ?string $content): Page|null
    {
        try {
            DB::beginTransaction();

            if ($content) {
                if (!$contentDTO = $this->createContentTable($content)) {
                    throw new BusinessLogicException(trans('exception.page.content.parsing'));
                }

                $data = array_merge($data, $contentDTO->toArray());
            }

            if (!$page = Page::create($data)) {
                throw new BusinessLogicException(trans('exception.page.model.save'));
            }

            DB::commit();
            return $page;

        } catch (Throwable $ex) {

            DB::rollBack();
            return null;
        }
    }

    public function update(Page $page, array $data, ?string $content): Page|null
    {
        try {
            DB::beginTransaction();

            if ($content) {
                if (!$contentDTO = $this->createContentTable($content)) {
                    throw new BusinessLogicException(trans('exception.page.content.parsing'));
                }

                $data = array_merge($data, $contentDTO->toArray());
            }

            if (!$page->update($data)) {
                throw new BusinessLogicException(trans('exception.pages.model.update'));
            }

            DB::commit();
            return $page;

        } catch (Throwable $ex) {

            DB::rollBack();
            return null;
        }
    }

    /**
     * @param UploadedFile|null $icon
     * @return string|null
     * @throws BusinessLogicException
     */
    public function saveIcon(?UploadedFile $icon): ?string
    {
        if ($icon) {
            if (!$iconPath = FileHelper::saveFile($icon, config('app.page.icon.path'))) {
                throw new BusinessLogicException(trans('exception.page.icon.save'));
            }

            return $iconPath;
        }
        return null;
    }

    /**
     * @param Page $page
     * @return bool
     * @throws BusinessLogicException
     */
    public function deleteIcon(Page $page): bool
    {
        $icon = $page->icon;

        if (!$page->update(['icon' => null])) {
            throw new BusinessLogicException(trans('exception.page.model.update'));
        }

        if (!FileHelper::deleteFile($icon, config('app.page.icon.path'))) {
            throw new BusinessLogicException(trans('exception.page.icon.save'));
        }

        return true;
    }

    /**
     * @param $file
     * @return string
     * @throws BusinessLogicException
     */
    public function uploadImage($file): string
    {
        if (!$filename = FileHelper::saveFile($file, config('app.page.image.path'))) {
            throw new BusinessLogicException(trans('exception.page.icon.save'));
        }

        return Storage::url(config('app.page.image.path') . '/' . $filename);
    }

    /**
     * @param string $content
     * @return PageContentDTO|null
     */
    public function createContentTable(string $content): ?PageContentDTO
    {
        try {
            $dom = new Dom();
            $dom->loadStr($content);

            $nodes = $dom->root->getChildren();

            $contentTable = [];

            $lastH2 = null;

            foreach ($nodes as $node) {
                /** @var InnerNode $node */

                /** @var Tag $tag */
                $tag = $node->tag;

                $idNode = md5(rand());

                switch ($tag->name()) {
                    case 'h2':
                        $node->tag->setAttribute('id', $idNode);

                        $lastH2 = new ContentTableDTO(
                            collect($node->getChildren())->first()->text,
                            $idNode,
                            []
                        );

                        $contentTable[] = $lastH2;

                        break;

                    case 'h3':
                        if (!is_null($lastH2)) {
                            $node->tag->setAttribute('id', $idNode);

                            $lastH2->addChild(
                                new ContentTableDTO(
                                    collect($node->getChildren())->first()->text,
                                    $idNode,
                                    [],
                                )
                            );
                        }

                        break;

                    default:
                        break;
                }
            }

            return new PageContentDTO((string)$dom, $contentTable);

        } catch (Throwable $ex) {
            Log::info('Exception while parsing content');
            Log::error($ex);
            return null;
        }
    }
}
