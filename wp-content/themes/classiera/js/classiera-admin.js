/*=====================================
Custom Script for Categories Custom Fields.
======================================*/
jQuery.noConflict();
jQuery(document).ready(function(jQuery){
	"use strict";
	jQuery.noConflict();
	/*=====================================
	Categories aJAX Function
	======================================*/
	var termID ;
	jQuery(document).on('change', '.classiera_customfields_cats', function (event){
		var thisCatID = jQuery(this).val();
		termID = jQuery(this).val();
		jQuery("#classiera_admin_custom_fields").empty();
		var data = {
			'action': 'classiera_adminside_customfields',
			'cat_ID': thisCatID,
		};
		jQuery.post(ajaxurl, data, function(response){
			if(response){
				jQuery("#classiera_admin_custom_fields").html(response);
			}
		});	
	});	
	jQuery(document).on('click', '.classiera_btn_ajax', function (){
		var $newItem;
		$newItem = jQuery('#template_badge_criterion_'+ termID +' .badge_item').clone().appendTo('#badge_criteria_'+termID +'').show();
		if ($newItem.prev('.badge_item').size() == 1) {
			var id = parseInt($newItem.prev('.badge_item').attr('id')) + 1;
		}else{
			var id = 0; 
		}
		$newItem.attr('id', id);
		var nameText = 'wpcrown_category_custom_field_option_'+ termID +'[' + id + '][0]';
		$newItem.find('.badge_name').attr('id', nameText).attr('name', nameText);
		var nameText2 = 'wpcrown_category_custom_field_type_'+ termID +'[' + id + '][1]';
		$newItem.find('.field_type').attr('id', nameText2).attr('name', nameText2);
		var nameText3 = 'wpcrown_category_custom_field_type_'+ termID +'[' + id + '][2]';
		$newItem.find('.options_c').attr('name', nameText3);
		
		jQuery(document).on('click', '.field_type_'+ termID +'', function (){
			var dropCVal = jQuery(this).val();
			if(dropCVal == 'dropdown'){
				jQuery(this).parent().next('td').find('#option_'+ termID +'').css('display','block');
			}else{
				jQuery(this).parent().next('td').find('#option_'+ termID +'').css('display','none');
			}
		});
	});
	jQuery(document).on('click', '.button_del_badge', function (){
		jQuery(this).closest('.badge_item').remove();
	});	
	/*=====================================
	Categories aJAX Function
	======================================*/
	jQuery(document).on('change', '#select-author', function (){	
		var aVal = jQuery("#select-author").val();
		jQuery(this).parent().parent().find(".wrap-content").css({"display":"none"});
		jQuery(this).parent().parent().find("#author-" + aVal).css({"display":"block"});
	});
	/*=====================================
	Categories upload thumb images function
	======================================*/
	var classiera_catIMG_uploader;
	jQuery('#category_image_button').click(function(e) {
		e.preventDefault();
		//If the uploader object has already been created, reopen the dialog
		if (classiera_catIMG_uploader) {
			classiera_catIMG_uploader.open();
			return;
		}
		classiera_catIMG_uploader = wp.media.frames.file_frame = wp.media({
			title: 'Choose Image',
			button: {
				text: 'Choose Image'
			},
			multiple: false
		});
		//When a file is selected, grab the URL and set it as the text field's value
		classiera_catIMG_uploader.on('select', function() {
			var attachment = classiera_catIMG_uploader.state().get('selection').first().toJSON();
			var url = '';
			url = attachment['url'];
			jQuery('#category_image').val(url);
			jQuery( "img#category_image_img" ).attr({
				src: url
			});
			jQuery("#category_image_button").css("display", "none");
			jQuery("#category_image_button_remove").css("display", "block");
		});
		//Open the uploader dialog
		classiera_catIMG_uploader.open();
	});
	jQuery('#category_image_button_remove').click(function(e) {
		jQuery('#category_image').val('');
		jQuery( "img#category_image_img" ).attr({
			src: ''
		});
		jQuery("#category_image_button").css("display", "block");
		jQuery("#category_image_button_remove").css("display", "none");
	});
	/*=====================================
	Categories upload icon images function
	======================================*/
	var classiera_iconIMG_uploader;
	jQuery('#your_image_url_button').click(function(e) {
		e.preventDefault();
		//If the uploader object has already been created, reopen the dialog
		if (classiera_iconIMG_uploader) {
			classiera_iconIMG_uploader.open();
			return;
		}
		//Extend the wp.media object
		classiera_iconIMG_uploader = wp.media.frames.file_frame = wp.media({
			title: 'Choose Image',
			button: {
				text: 'Choose Image'
			},
			multiple: false
		});
		//When a file is selected, grab the URL and set it as the text field's value
		classiera_iconIMG_uploader.on('select', function() {
			var attachment = classiera_iconIMG_uploader.state().get('selection').first().toJSON();
			var url = '';
			url = attachment['url'];
			jQuery('#your_image_url').val(url);
			jQuery( "img#your_image_url_img" ).attr({
				src: url
			});
			jQuery("#your_image_url_button").css("display", "none");
			jQuery("#your_image_url_button_remove").css("display", "block");
		});
		//Open the uploader dialog
		classiera_iconIMG_uploader.open();
	});
	jQuery('#your_image_url_button_remove').click(function(e) {
		jQuery('#your_image_url').val('');
		jQuery( "img#your_image_url_img" ).attr({
			src: ''
		});
		jQuery("#your_image_url_button").css("display", "block");
		jQuery("#your_image_url_button_remove").css("display", "none");
	});
	
});