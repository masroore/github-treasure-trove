<form wire:submit.prevent="addQuestions">
    @csrf
    <div class="row">
        <div class="form-group col-md-12 col-12">
            <label>{{ __('security.q1') }}
            </label>
            <div class="input-group">
                <select wire:model.lazy="question_1" class="form-control {{ $errors->has('question_1') ? ' is-invalid' : '' }}">
                    <option value="" selected>{{ __('security.q1_placeholder') }}</option>
                    <option value="What was your childhood nickname?">What was your childhood nickname?</option>
                    <option value="In what city or town did your mother and father meet?">In what city or town did your mother and father meet?</option>
                    <option value="What is your favorite team?">What is your favorite team?</option>
                    <option value="What was your favorite sport in high school?">What was your favorite sport in high school?</option>
                    <option value="What is the first name of the boy or girl that you first kissed?">What is the first name of the boy or girl that you first kissed?</option>
                    <option value="What was the name of the hospital where you were born?">What was the name of the hospital where you were born?</option>
                    <option value="What school did you attend for sixth grade?">What school did you attend for sixth grade?</option>
                    <option value="In what town was your first job?">In what town was your first job?</option>
                </select>
            </div>
            @error('question_1') <span class="error text-danger">{{ $message }}</span> @enderror
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-12 col-12">
            <label>{{ __('security.a1') }}
            </label>
            <div class="input-group">
                <input type="text" class="form-control {{ $errors->has('answer_1') ? ' is-invalid' : '' }}" wire:model.lazy="answer_1" placeholder="{{ __('security.a1_placeholder') }}">
            </div>
            @error('answer_1') <span class="error text-danger">{{ $message }}</span> @enderror
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="form-group col-md-12 col-12">
            <label>{{ __('security.q2') }}
            </label>
            <div class="input-group">
                <select wire:model.lazy="question_2" class="form-control {{ $errors->has('question_2') ? ' is-invalid' : '' }}">
                    <option value="" selected>{{ __('security.q2_placeholder') }}</option>
                    <option value="What is the name of your favorite childhood friend?">What is the name of your favorite childhood friend?</option>
                    <option value="What is the middle name of your oldest child?">What is the middle name of your oldest child?</option>
                    <option value="What is your favorite movie?">What is your favorite movie?</option>
                    <option value="What was your favorite food as a child?">What was your favorite food as a child?</option>
                    <option value="What was the make and model of your first car?">What was the make and model of your first car?</option>
                    <option value="Who is your childhood sports hero?">Who is your childhood sports hero?</option>
                    <option value="What was the last name of your third grade teacher?">What was the last name of your third grade teacher?</option>
                    <option value="What was the name of the company where you had your first job?">What was the name of the company where you had your first job?</option>
                </select>
            </div>
            @error('question_2') <span class="error text-danger">{{ $message }}</span> @enderror
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-12 col-12">
            <label>{{ __('security.a2') }}
            </label>
            <div class="input-group">
                <input type="text" class="form-control {{ $errors->has('answer_2') ? ' is-invalid' : '' }}" wire:model.lazy="answer_2" placeholder="{{ __('security.a2_placeholder') }}">
            </div>
            @error('answer_2') <span class="error text-danger">{{ $message }}</span> @enderror
        </div>
    </div>
    <div class="row text-center">
        <div class="form-group col-md-12 col-12">
            <button class="btn btn-primary" type="submit">{{ __('security.questions_btn') }}</button>
        </div>
    </div>
</form>