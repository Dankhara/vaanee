/*===========================================================================
*
*  AUDIO FILE UPLOAD - FILEPOND PLUGIN
*
*============================================================================*/

FilePond.registerPlugin(

  FilePondPluginFileValidateSize,
  FilePondPluginFileValidateType

);

var pond = FilePond.create(document.querySelector('.filepond'));
var all_types;
var maxFileSize;

$.ajax({
  headers: {
    'X-CSRF-TOKEN': '{{ csrf_token() }}',
  },
  type: "GET",
  url: config.routes.zone,

}).done(function (data) {

  maxFileSize = 2048 + 'MB';

  pond.setOptions({

    allowMultiple: false,
    maxFiles: 1,
    allowReplace: true,
    maxFileSize: maxFileSize,
    labelIdle: "Drag & Drop your file or <span class=\"filepond--label-action\">Browse</span><br><span class='restrictions'>[<span class='restrictions-highlight'>" + maxFileSize + "</span>: MP4 | mkv]</span>",
    required: false,
    instantUpload: false,
    storeAsFile: true,
    acceptedFileTypes: ['video/*'],
    labelFileProcessingError: (error) => {
      console.log(error);
    }

  });

});


