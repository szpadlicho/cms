/*ważne! wersja jQuery nie nowsza niż 1.5.2*/
$(document).ready(function(){//pokazywanie i ukrywanie po kliknięciu buttonów		
	$('#form_b_up').click(function(){	
		$('.upload-place-holder').css('display', 'block');
		$('.new-place-holder').css('display', 'none');
		$('.rename-place-holder').css('display', 'none');
	});
	$('#form_b_new').click(function(){				
		$('.new-place-holder').css('display', 'block');
		$('.upload-place-holder').css('display', 'none');
		$('.rename-place-holder').css('display', 'none');
	});
	$('#form_b_rename').click(function(){				
		$('.rename-place-holder').css('display', 'block');
		$('.new-place-holder').css('display', 'none');
		$('.upload-place-holder').css('display', 'none');
	});
	$('.anuluj').click(function(){				
		$('.rename-place-holder').css('display', 'none');
		$('.new-place-holder').css('display', 'none');
		$('.upload-place-holder').css('display', 'none');
	});	
});
//------------------------------------------------------
$(document).ready(function(){//zaznacz wszystko checkbox
	$('#cmd_check_back').change(function() {
		var checkboxes = $(this).closest('form').find(':checkbox');
		if($(this).is(':checked')) {
			checkboxes.attr('checked', 'checked');
		} else {
			checkboxes.removeAttr('checked');
		}
	});
});
