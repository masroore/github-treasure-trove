<div class="form-widget topmargin">
    <div class="form-result"></div>
    <form class="nobottommargin" action="{{ route('kontakt.send') }}" method="post">
        @csrf
        <div class="form-process"></div>
        <div class="col_one_third">
            <label for="contactform-name">Ime <span style="color: red;">*</span></label>
            <input type="text" name="name" value="" class="sm-form-control required" />
        </div>
        <div class="col_one_third">
            <label for="contactform-email">Email <span style="color: red;">*</span></label>
            <input type="email" name="email" value="" class="required email sm-form-control" />
        </div>
        <div class="col_one_third col_last">
            <label for="contactform-subject">Telefon</label>
            <input type="text" name="phone" value="" class="sm-form-control" />
        </div>
        <div class="clear"></div>
        <div class="col_full">
            <label for="contactform-message_content">Upit <span style="color: red;">*</span></label>
            <textarea class="required sm-form-control" name="message" rows="6" cols="30"></textarea>
        </div>
        <div class="col_full hidden">

        </div>
        <div class="col_full">
            <button class="button button-3d nomargin" type="submit">Pošaljite upit</button>
        </div>

        <input type="hidden" name="recaptcha" id="recaptcha">
    </form>
</div>

@push('js')
    @include('front.layouts.partials.recaptcha-js')
@endpush
