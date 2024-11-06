<x-app-admin-layout>
    @section('pageTitle', 'Marketing FAQs Edit')
    @section('custom_style')
    @endsection

    <x-slot name="header">
        <x-header>
            {{ __('Edit FAQ') }}
        </x-header>
    </x-slot>

    <div class="py-2">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <form action="{{ route('admin.faqs.update', $faq) }}" method="POST">
                            <div class="card-body">
                                @csrf
                                @method('PUT')
                                @foreach(config('constants.languages') as $shortCode => $language)
                                    <fieldset class="language-fieldset language-fieldset-{{ $shortCode }}">
                                        <legend>{{ $language }}</legend>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group mb-3">
                                                    <label class="form-label" for="question-{{ $shortCode }}">Question</label>
                                                    <input type="text" name="question[{{ $shortCode }}]" id="question-{{ $shortCode }}" class="form-control @error('question.' . $shortCode) is-invalid @enderror" placeholder="Question" value="{{ old('question.' . $shortCode, $faq->getTranslation('question', $shortCode)) }}" required autofocus>
                                                    @error('question.' . $shortCode)
                                                    <x-error-alert :message="$message" />
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group mb-3">
                                                    <label class="form-label" for="answer-{{ $shortCode }}">Answer</label>
                                                    <textarea name="answer[{{ $shortCode }}]" id="answer-{{ $shortCode }}" class="form-control @error('answer.' . $shortCode) is-invalid @enderror" rows="3" placeholder="Answer" required>{{ old('answer.' . $shortCode, $faq->getTranslation('answer', $shortCode)) }}</textarea>
                                                    @error('answer.' . $shortCode)
                                                    <x-error-alert :message="$message" />
                                                    @enderror
                                                </div>
                                            </div>
                                            
                                            {{-- <div class="col-md-12">
                                                <div class="form-group mb-3">
                                                    <label class="form-label" for="type-{{ $shortCode }}">Type</label>
                                                    <select name="type[{{ $shortCode }}]" id="type-{{ $shortCode }}" class="form-control @error('type.' . $shortCode) is-invalid @enderror" required>
                                                        @foreach(config('constants.faq_types')[$shortCode] as $type)
                                                            <option value="{{ $type }}" @if(old('type.' . $shortCode, $faq->getTranslation('type', $shortCode)) === $type) selected @endif>{{ $type }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('type.' . $shortCode)
                                                    <x-error-alert :message="$message" />
                                                    @enderror
                                                </div>
                                            </div> --}}
                                        </div>
                                    </fieldset>
                                    <hr>
                                @endforeach

                                <fieldset>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group mb-3">
                                                <label class="form-label" for="faq-type-id">Type</label>
                                                <select name="faq_type_id" id="faq-type-id" class="form-control @error('faq_type_id') is-invalid @enderror" required>
                                                    @foreach($faqTypes as $faqType)
                                                        <option value="{{ $faqType->id }}" @if(old('faq_type_id', $faq->faq_type_id) === $faqType->id) selected @endif>{{ $faqType->getTranslation('name', session('locale', 'es')) }}</option>
                                                    @endforeach
                                                </select>
                                                @error('faq_type_id')
                                                <x-error-alert :message="$message" />
                                                @enderror
                                            </div>
                                        </div>                                        
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-md-4">
                                            <div class="form-group mb-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" id="is-active" type="checkbox" name="is_active" value="1" @if($faq->is_active) checked @endif>
                                                    <label class="form-check-label" for="is-active">Is Active ?</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                                
                            </div>
                            <div class="card-footer">
                                <div class="row py-2">
                                    <div class="col-md-12">
                                        <x-submit-button class="mr-4">
                                            {{ __('Submit') }}
                                        </x-submit-button>
                                        <a href="{{ route('admin.faqs.index') }}">
                                            <button type="button" class="btn waves-effect waves-light btn-outline-dark rounded-md">Cancel</button>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @section('custom_script')
    @endsection
</x-app-admin-layout>
