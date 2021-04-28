<?php
/*==========================
Classiera delete thumbnail
===========================*/
if (!function_exists('classiera_delete_thumbnail')) {
	function classiera_delete_thumbnail($image_path){
		$thumb_deleted = array();
		$thumb_error = array();
		$thumb_regenerate = array();		
		/*==========================
		Hack to find thumbnail
		===========================*/
		$file_info = pathinfo($image_path);
		$file_info['filename'] .= '-';
		$files = array();
		$path = opendir($file_info['dirname']);
		if ( false !== $path ) {
			while (false !== ($thumb = readdir($path))) {
				if (!(strrpos($thumb, $file_info['filename']) === false)) {
					$files[] = $thumb;
				}
			}
			closedir($path);
			sort($files);
		}
		foreach ($files as $thumb) {
			$thumb_fullpath = $file_info['dirname'] . DIRECTORY_SEPARATOR . $thumb;
			$thumb_info = pathinfo($thumb_fullpath);
			$valid_thumb = explode($file_info['filename'], $thumb_info['filename']);
			if ($valid_thumb[0] == "") {
				$dimension_thumb = explode('x', $valid_thumb[1]);
				if (count($dimension_thumb) == 2) {
					if (is_numeric($dimension_thumb[0]) && is_numeric($dimension_thumb[1])) {
						unlink($thumb_fullpath);
						if (!file_exists($thumb_fullpath)) {
							$thumb_deleted[] = sprintf("%sx%s", $dimension_thumb[0], $dimension_thumb[1]);
						} else {
							$thumb_error[] = sprintf("%sx%s", $dimension_thumb[0], $dimension_thumb[1]);
						}
					}
				}
			}
		}
	}
}
/*==========================
Classiera Dropzone Upload image function
===========================*/
if (!function_exists('classiera_media_upload')) {
	add_action( 'wp_ajax_nopriv_classiera_media_upload', 'classiera_media_upload' );
	add_action( 'wp_ajax_classiera_media_upload', 'classiera_media_upload' );
	function classiera_media_upload(){
		/*==========================
		Classiera upload image
		===========================*/
		if(isset($_FILES)){	
			require_once(ABSPATH . "wp-admin" . '/includes/image.php');
			require_once(ABSPATH . "wp-admin" . '/includes/file.php');
			require_once(ABSPATH . "wp-admin" . '/includes/media.php');
			$files = $_FILES['file'];			
			foreach ($files['name'] as $key => $value) {
				if ($files['name'][$key]) {
					$file = array(
						'name'     => $files['name'][$key],
						'type'     => $files['type'][$key],
						'tmp_name' => $files['tmp_name'][$key],
						'error'    => $files['error'][$key],
						'size'     => $files['size'][$key]
					);
					$_FILES = array("upload" => $file);
					foreach ($_FILES as $file => $array){
						$attachedID = media_handle_upload( $file, 0 );
					}
				}
			}			
			echo $attachedID;			 			
		}
		/*==========================
		BeeMotor delete attached image
		===========================*/
		if(isset($_POST['delete_attached'])){
			$attachedID = absint($_POST['delete_attached'] );
			$filepath = get_attached_file($attachedID);
			classiera_delete_thumbnail($filepath);
			wp_delete_file($filepath, false);
			$status = wp_delete_attachment($attachedID, true);
			if( $status ){
				echo json_encode(
					array(
						'delete'=> true,						
					)
				);
			}else{
				echo json_encode(
					array(
						'delete'=> false,						
					)
				);
			}
		}
		die();
	}
}