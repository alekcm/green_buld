<?php

namespace App\Services\SelectionInfos;

use App\Enums\SelectionInfoEnum;
use App\Exceptions\BusinessLogicException;
use App\Helpers\FileHelper;
use App\Models\SelectionInfo;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Throwable;

class SelectionInfoService
{
    public function store(string $filename): bool
    {
        try {
            DB::beginTransaction();

            $fullPath = config('app.selection_info.path') . '/' . $filename;
            $fullPath = Storage::disk('public')->path($fullPath);

            $data = $this->getDataFromSpreadsheet(
                $fullPath,
                SelectionInfoEnum::START_ROW,
                SelectionInfoEnum::START_COLUMN,
                SelectionInfoEnum::RELATION,
                SelectionInfoEnum::TO_DATE,
                SelectionInfoEnum::VALIDATION_RULES,
            );

            if (is_null($data)) {
                throw new BusinessLogicException(trans('exception.selection_info.model.empty'));
            }

            $unique = $this->checkUnique($data, 'lot_number');

            if ($unique !== true) {
                throw new BusinessLogicException(trans('exception.selection_info.model.duplicate_lot_number', ['lots' => implode(', ', $unique)]));
            }

            SelectionInfo::query()->delete();
            SelectionInfo::insert($data);

            DB::commit();

            return true;

        } catch (Throwable $ex) {
            DB::rollBack();

            if ($ex instanceof BusinessLogicException) {
                throw $ex;
            }

            return false;
        }
    }

    public function getDataFromSpreadsheet(string $filename, int $startRow, int $startColumn, array $config, array $castToDate, array $validationRules): ?array
    {
        try {
            $spreadsheet = IOFactory::load($filename);
            $worksheet = $spreadsheet->getActiveSheet();
            $highestRow = $worksheet->getHighestRow();

            $data = [];
            $timeNow = now();

            for ($row = $startRow; $row <= $highestRow; ++$row) {

                $temp = [];

                foreach ($config as $column => $value) {
                    $temp[$value] = $worksheet->getCellByColumnAndRow($column + $startColumn, $row)->getValue();

                    if (in_array($column, $castToDate) && !is_null($temp[$value])) {
                        $temp[$value] = Carbon::createFromTimestamp(Date::excelToDateTimeObject($temp[$value])->getTimestamp());
                    }
                }

                $validator = Validator::make($temp, $validationRules);
                if (!$validator->fails()) {
                    $temp['created_at'] = $timeNow;
                    $data[] = $temp;
                }
            }

            return $data;

        } catch (Throwable $exception) {
            Log::info('Exception while parsing spreadsheet');
            Log::error($exception);
            return null;
        }
    }

    public function checkUnique(array $data, string $uniqueKey): array|bool
    {
        $values = array_map(function (array $item) use ($uniqueKey) {
            return $item[$uniqueKey];
        }, $data);

        $counts = array_count_values($values);

        $duplicates = array_filter($counts, function ($item) {
            return $item !== 1;
        });

        if (count($duplicates)) {
            return array_keys($duplicates);
        }

        return true;
    }

    /**
     * @param UploadedFile $file
     * @return string
     * @throws BusinessLogicException
     */
    public function upload(UploadedFile $file): string
    {
        if (!$filename = FileHelper::saveFile($file, config('app.selection_info.path'))) {
            throw new BusinessLogicException(trans('exception.save_file'));
        }

        return $filename;
    }
}
