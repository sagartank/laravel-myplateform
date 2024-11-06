
<x-app-marketing-layout>
    @section('pageTitle', 'FAQ')
    <div class="frequently fre_wrap">
        <div class="container">
            <div class="frequently_section">
                <div class="title">
                    <h3>{{ __('Frequently asked questions') }}?</h3>
                    <p>{{ __('Quick answer to questions you may have') }}.</p>
                </div>
                <div class="tab_accordion">
                    
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        @if($faqs->isNotEmpty())
                            @foreach($faqs->groupBy('faq_type_id') as $type => $typeGroup)
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link @if($loop->first) active @endif" data-bs-toggle="tab" data-bs-target="#type-{{ $type }}" type="button" role="tab" aria-controls="home" aria-selected="true">{{ $typeGroup->first()->type->getTranslation('name', session('locale', 'es')) }}</button>
                                </li>
                            @endforeach
                        @endif
                    </ul>

                    <div class="tab-content" id="frequently_content">
                        @if($faqs->isNotEmpty())
                            @foreach($faqs->groupBy('faq_type_id') as $type => $typeGroup)
                                <div class="tab-pane fade @if($loop->first) show active @endif" id="type-{{ $type }}" role="tabpanel" aria-labelledby="general-tab">
                                    <div class="accordion" id="accordionPanelsStayOpenExample">
                                        @foreach($typeGroup as $faq)
                                            <div class="accordion-item">
                                                <h6 class="accordion-header">
                                                    <button class="accordion-button  @if(!$loop->first) collapsed  @endif" type="button" data-bs-toggle="collapse" data-bs-target="#faq-{{ $faq->slug }}" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
                                                        {{ $faq->getTranslation('question', session('locale', 'es')) }}
                                                    </button>
                                                </h6>
                                                <div id="faq-{{ $faq->slug }}" class="accordion-collapse collapse @if($loop->first) show  @endif">
                                                    <div class="accordion-body">
                                                        <p>{{ $faq->getTranslation('answer', session('locale', 'es')) }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-marketing-layout>