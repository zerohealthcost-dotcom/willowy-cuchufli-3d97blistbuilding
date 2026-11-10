/**
 * @license Copyright (c) 2003-2019, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.editorConfig = function( config ) {
	// %REMOVE_START%
	// The configuration options below are needed when running CKEditor from source files.
	config.plugins = 'basicstyles,blockquote,dialogui,dialog,notification,button,toolbar,clipboard,panelbutton,panel,floatpanel,colorbutton,colordialog,menu,contextmenu,elementspath,enterkey,entities,popup,filetools,filebrowser,find,floatingspace,listblock,richcombo,font,format,horizontalrule,htmlwriter,image,indent,indentlist,justify,fakeobjects,link,list,magicline,maximize,pastetext,removeformat,resize,menubutton,scayt,showborders,sourcearea,specialchar,stylescombo,tab,table,tabletools,tableselection,undo,lineutils,widgetselection,widget,notificationaggregator,uploadwidget,uploadimage,wysiwygarea,lineheight';
	config.skin = 'moono';
	// %REMOVE_END%
	// Define changes to default configuration here.
	// For complete reference see:
	// https://ckeditor.com/docs/ckeditor4/latest/api/CKEDITOR_config.html

	// The toolbar groups arrangement, optimized for two toolbar rows.
	config.toolbarGroups = [
		{ name: 'clipboard',   groups: [ 'clipboard', 'undo' ] },
		{ name: 'editing',     groups: [ 'find', 'selection', 'spellchecker' ] },
		{ name: 'links' },
		{ name: 'insert' },
		{ name: 'forms' },
		{ name: 'tools' },
		{ name: 'document',	   groups: [ 'mode', 'document', 'doctools' ] },
		{ name: 'others' },
		{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
		{ name: 'paragraph',   groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ] },
		{ name: 'styles' },
		{ name: 'colors' },
		{ name: 'about' }
	];

	// Remove some buttons provided by the standard plugins, which are
	// not needed in the Standard(s) toolbar.
	config.removeButtons = 'Underline,Subscript,Superscript';

	// Set the most common block elements.
	config.format_tags = 'p;h1;h2;h3;pre';

	// Simplify the dialog windows.
	config.removeDialogTabs = 'image:advanced;link:advanced';
	
	// This plugin provides the Advanced dialog window tab to extend some editor dialog windows.
	config.extraPlugins = 'dialogadvtab';
	
	 // Lineheight values, customize as needed
	config.line_height = '0.5;0.6;0.7;0.8;0.9;1;1.1;1.2;1.3;1.4;1.5;1.6;1.7;1.8;1.9;2;2.5;3';
	
	// Additional font sizes.
	config.fontSize_sizes = '8/8px;9/9px;10/10px;11/11px;12/12px;14/14px;16/16px;18/18px;20/20px;22/22px;24/24px;26/26px;28/28px;30/30px;32/32px;34/34px;36/36px;38/38px;40/40px;42/42px;44/44px;46/46px;48/48px;50/50px;52/52px;54/54px;72/72px';
	
	// Allow Script
	config.allowedContent = true;
	config.filebrowserBrowseUrl = ''
	config.filebrowserUploadUrl =  './ckeditor/imageuploader/imgupload.php';
	config.filebrowserImageUploadUrl =  './ckeditor/imageuploader/imgupload.php';
	config.extraAllowedContent = 'p(*)[*]{*};div[id]';
	config.allowedContent = {
		script: true,
		$1: {
			// This will set the default set of elements
			elements: CKEDITOR.dtd,
			attributes: true,
			styles: true,
			classes: true
		}
	};

};
