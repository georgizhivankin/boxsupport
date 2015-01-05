$(document).ready(function() {
	// Submit the form with the changed rating for a given product on change
$('.selectRating').on('change', function(e){
    $(this).closest('form').submit();
});
});