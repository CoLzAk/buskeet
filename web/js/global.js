$(document).ready(function() {
	NProgress.configure({ 
		showSpinner: false,
		ease: 'ease',
		speed: 1000
	});
    $('#login-button').on('click', function(e) {
        $('#login-form').submit();
    });
});