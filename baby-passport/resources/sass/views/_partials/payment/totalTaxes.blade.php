<div class="totalNoTaxes">
    <h1 class="h1-responsive text-ce-soir">
        $ {{number_format($maternityPackage["subtotal"],2)}} USD
    </h1>

    <p class="lead text-justify text-ce-soir font-weight-bolder">
        {{$maternityPackage  ? $maternityPackage["description"]:''}}
    </p>
</div>


<div class="totalTaxes" style="display: none;">
    <h3 class="text-ce-soir my-2">
        $ {{number_format($maternityPackage["subtotal"],2)}} USD

    </h3>
    <h3 class="text-ce-soir my-2">+ IVA</h3>
    <h3 class="text-ce-soir my-2">
        $ {{number_format($maternityPackage["iva"],2)}} USD
    </h3>

    <p class="text-justify text-grey-suit font-weight-bolder">
        {{$maternityPackage  ? $maternityPackage["description"]:''}}
    </p>

</div>
