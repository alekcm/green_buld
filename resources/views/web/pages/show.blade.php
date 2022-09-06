@extends('layouts.user')

@section('title')
    {{ trans('message.title', ['title' => $model->title]) }}
@endsection

@section('content')
    <div class="content">
        @component('components.breadcrumbs', [
            'breadcrumbs' => $model->breadcrumbs,
        ])@endcomponent
        <h1>{{ $model->title }}</h1>
        <div class="panels">
            @foreach($model->availableChildren(Auth::user())->get() as $child)
                <a class="panels__item" href="{{ route('web.pages.show', $child->path) }}">
                    <p>{{ $child->title }}</p>
                    @if(!is_null($child->icon))
                        <img src="{{ asset(Storage::url($child->icon_path)) }}" alt="">
                    @endif
                </a>
            @endforeach
        </div>

        @isset($model->content)
            <div class="page-content" id="topPageContent">
                <aside class="page-content__nav">
                    <div class="treeview-nav">
                        <ul>
                            @foreach($model->content_table as $contentItem)
                                <li>
                                    <a class="" href="javascript:" onclick="scrollById('{{ $contentItem['id'] }}');">
                                        {{ $contentItem['name'] }}
                                    </a>
                                    @if(count($contentItem['children']))
                                        <ul class="">
                                            @foreach($contentItem['children'] as $child)
                                                <li>
                                                    <a href="javascript:"
                                                       onclick="scrollById('{{ $child['id'] }}');">
                                                        {{ $child['name'] }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </aside>


                <div class="page-content__content" id="pageContent">
                    {!! $model->content !!}
                    <button type="button" class="page-content__content-button"
                            onclick="scrollById('topPageContent');">
                        К началу статьи
                    </button>
                </div>
            </div>
        @endisset
    </div>

    <script src="{{ asset('js/vendor/swiper.min.js') }}"></script>
    <script>
        function scrollById(id) {
            window.scrollTo({
                behavior: 'smooth',
                top:
                    document.getElementById(id).getBoundingClientRect().top -
                    document.body.getBoundingClientRect().top -
                    60,
            })
        }

        let pageContent = document.getElementById('pageContent');

        if (pageContent) {
            pageContent.querySelectorAll('img').forEach((x, index) => {

                // Check if img in slider - if NO then make it popup
                if (!x.closest('.js-slider')) {
                    x.classList.add('img-magnific-popup');
                    $(x).magnificPopup({
                        type: 'image',
                        removalDelay: 300,
                        gallery: {
                            enabled: true,
                        },
                        mainClass: 'mfp-with-zoom',
                        zoom: {
                            enabled: true,
                            duration: 300,
                            easing: 'ease-in-out',
                            opener: function (openerElement) {
                                return openerElement.is('img') ? openerElement : openerElement.find('img');
                            }
                        },
                        callbacks: {
                            elementParse: function (qw) {
                                qw.src = qw.el.attr('src');
                            }
                        }
                    })
                }
            })
        }


        document.querySelectorAll('.js-slider').forEach((x, index) => {

            let wrapper = document.createElement('div');
            wrapper.classList.add('swiper-wrapper')
            x.appendChild(wrapper);

            x.querySelectorAll('img').forEach(y => {

                let nextSibling = y.nextElementSibling;
                let imageCaption = null;
                if (nextSibling.tagName === 'BR') {
                    let expectedText = nextSibling.nextSibling;
                    if (expectedText.nodeName === '#text') {
                        imageCaption = document.createElement('div');
                        imageCaption.classList.add('swiper-caption');
                        imageCaption.innerText = expectedText.textContent;
                        expectedText.remove();
                        y.setAttribute('title', expectedText.textContent);
                    }
                    nextSibling.remove();
                }

                let parent = y.parentNode;
                let wrapperY = document.createElement('div');
                wrapperY.classList.add('swiper-slide');

                parent.replaceChild(wrapperY, y);
                wrapperY.appendChild(y);

                if (imageCaption) {
                    wrapperY.append(imageCaption);
                }

                wrapper.appendChild(wrapperY);
            });

            let btnPrev = document.createElement('div');
            btnPrev.classList.add('swiper-button-prev');
            btnPrev.classList.add('swiper-button-prev-' + index);

            let btnNext = document.createElement('div');
            btnNext.classList.add('swiper-button-next');
            btnNext.classList.add('swiper-button-next-' + index);
            x.appendChild(btnPrev);
            x.appendChild(btnNext);

            let sw = new Swiper(x, {
                speed: 400,
                spaceBetween: 100,
                createElements: true,
                effect: "slide",
                grabCursor: true,
                navigation: {
                    nextEl: ".swiper-button-next-" + index,
                    prevEl: ".swiper-button-prev-" + index,
                },
            });

            let popup_open = 0;

            $(x).magnificPopup({
                delegate: 'img',
                type: 'image',
                removalDelay: 300,
                gallery: {
                    enabled: true,
                    tPrev: 'Назад', // title for left button
                    tNext: 'Вперед', // title for right button
                    arrowMarkup: '<button title="%title%" type="button" class="mfp-arrow mfp-arrow-%dir%"></button>', // markup of an arrow button
                    tCounter: '<span class="mfp-counter">%curr% из %total%</span>' // markup of counter
                },
                mainClass: 'mfp-with-zoom',
                image: {
                    titleSrc: function (item) {
                        return item.el.attr('title');
                    }
                },
                zoom: {
                    enabled: true,
                    duration: 300,
                    easing: 'ease-in-out',
                    opener: function (openerElement) {
                        return openerElement.is('img') ? openerElement : openerElement.find('img');
                    }
                },
                callbacks: {
                    elementParse: function (qw) {
                        qw.src = qw.el.attr('src');
                    },

                    open: function () {
                        popup_open = 1;
                        let mfp = $.magnificPopup.instance;
                        let proto = $.magnificPopup.proto;

                        mfp.next = function () {
                            if (mfp.index < mfp.items.length - 1) {
                                proto.next.call(mfp);
                            }
                        }

                        mfp.prev = function () {
                            if (mfp.index > 0) {
                                proto.prev.call(mfp);
                            }
                        }
                    },

                    change: function () {
                        if (popup_open === 1) {
                            sw.slideTo(this.index);
                        }
                    },

                    close: function () {
                        popup_open = 0;
                    }
                }
            })
        })
    </script>
@endsection
