@if (!Browser::isChrome() ) 
    <div class="alert alert-alert row col-12 d-none" style="
    color: #856404;
    background-color: #fff3cd;
    border-color: #ffeeba;margin-top:10px;position: absolute;bottom:0px; z-index:2000;">
        <img src="{{asset('assets/gsa/img/chrome.png')}}" class="col- " style="object-fit: contain; width:50px; ">
        <div class="col-11">
            Untuk kelancaran scan QR, Gunakan browser google chrome
            <a href="https://www.google.com/chrome/?brand=CHBD&gclid=CjwKCAjw7fuJBhBdEiwA2lLMYXmsMZsuOvkh0CG2ld2zkAV2WnWiVakTdwrk5F-g2BPEY1yQjqNLGhoCqsoQAvD_BwE&gclsrc=aw.ds">
                click disini untuk download chrome
            </a> atau download pada playstore/appstore
        </div>
    </div>
@endif 
<div class="alert alert-alert row col-12 d-none" id='cameraaccessdenied' style="
color: #853304;
background-color: #ffcdcd; 
border-color: #ffbabd;margin-top:10px;position: absolute;bottom:70px; z-index:2000;">
<div class="col-12">
    Akses kamera membutuhkan izin browser!
    Click <a href="https://support.google.com/chrome/answer/2693767?hl=en&co=GENIE.Platform%3DAndroid"> Disini </a> untuk memberikan akses kamera
</div>

</div>