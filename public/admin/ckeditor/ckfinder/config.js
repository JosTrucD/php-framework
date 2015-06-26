/**
 * @license Copyright (c) 2003-2014, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
	var url='http://thaibinhthienquoc.com/public/admin/ckeditor_finder/';
    config.filebrowserBrowseUrl         =url+ 'ckfinder/ckfinder.html';
    config.filebrowserImageBrowseUrl  	=url+ 'ckfinder/ckfinder.html?type=Images';
    config.filebrowserFlashBrowseUrl 	=url+ 'ckfinder/ckfinder.html?type=Flash';
    config.filebrowserUploadUrl 	=url+ 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files';
    config.filebrowserImageUploadUrl 	=url+ 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images';
    config.filebrowserFlashUploadUrl 	=url+ '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash';
};
