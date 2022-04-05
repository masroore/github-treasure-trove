$(function() {
    $("#smartwizard").smartWizard({
        theme:'circles',

        toolbarSettings: {
            toolbarPosition: 'none', // none, top, bottom, both
         }, // show/hide a Previous button
        anchorSettings: {
            anchorClickable: true, // Enable/Disable anchor navigation
            enableAllAnchors: true, // Activates all anchors clickable all times
            markDoneStep: false, // add done css
        },
        transitionEffect: 'slide', // Effect on navigation, none/slide/fade
        transitionSpeed: '400'
    });

    $("#main-anchor")[0].click();
});
