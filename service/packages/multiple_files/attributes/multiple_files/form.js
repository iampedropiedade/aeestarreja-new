var MultipleFilesAttribute = {
    addFileToList: function(akID, fileInfo) {
        let fileList = $('#multiple-files-ak'+akID);
        let template = $('#file-input-template-ak'+akID);
        let file = template.tmpl({
            fID: fileInfo.fID,
            thumbnailIMG: $(fileInfo.thumbnailIMG),
            filename: fileInfo.fID
        }).appendTo(fileList);
        file.find('.icon').append($(fileInfo.thumbnailIMG));
    },

    removeFileDOM: function(fileInfoDOM) {
        fileInfoDOM.hide('fast', function () {
            fileInfoDOM.remove();
        });
    },

    checkLimit: function(akID, max_count){
        let currentCount = $('#multiple-files-ak'+akID).find('.selected-file').length;
        if (max_count > 0 && currentCount >= max_count) {
            ConcreteAlert.error({message: 'You can add up to ' + max_count + ' files to this attribute.', delay: 3000});
            return false;
        } else {
            return true;
        }
    },

    initListeners: function(akID, max_count, token) {
        let fileListJQuery = $('#multiple-files-ak'+akID);
        fileListJQuery.sortable();
        fileListJQuery.disableSelection();
        fileListJQuery.on( "click", ".selected-file .delete", function() {
            MultipleFilesAttribute.removeFileDOM($(this).closest('.selected-file'));
        });

        $('button[data-akid='+akID+'][data-launch=file-manager]').on('click', function(e) {
            e.preventDefault();
            var akID = $(this).data('akid');
            if (MultipleFilesAttribute.checkLimit(akID, max_count)) {
                ConcreteFileManager.launchDialog(function (data) {
                    if (data.fID) {
                        if (MultipleFilesAttribute.checkLimit(akID, max_count-data.fID.length+1)) {
                            MultipleFilesAttribute.setFiles(akID, data.fID, token);
                        }
                    }
                }, {
                    multipleSelection: true,
                    selectMode: 'multiple'
                });
            }
        });
    },

    getFilesInfo: function(fileIds, token, callback) {
        $.ajax({
            url: CCM_DISPATCHER_FILENAME + "/ccm/multiple_files_attribute/get_file_info/",
            data: {fIDs:fileIds, ccm_token:token},
            dataType: "JSON",
            method: "GET"
        }).done(callback);
    },

    setFiles: function(akID, fileIds, token) {
        MultipleFilesAttribute.getFilesInfo(fileIds, token, function(data){
            if (!data.error) {
                let fileListJQuery = $('#multiple-files-ak'+akID);
                $.each(data, function(index, fileInfo) {
                    let duplicateFile = fileListJQuery.find('.selected-file[data-fid='+fileInfo.fID+']');
                    if (duplicateFile.length) {
                        MultipleFilesAttribute.removeFileDOM(duplicateFile)
                    }
                    MultipleFilesAttribute.addFileToList(akID, fileInfo);
                });
            }
            else {
                ConcreteAlert.error({message: data.errors, delay: 3000});
            }
        });
    },

    init: function(akID, multipleFilesCurrentSelected, max_count, token) {

        if ($.isArray(multipleFilesCurrentSelected) && multipleFilesCurrentSelected.length) {
            $.each(multipleFilesCurrentSelected, function(index, fileInfo) {
                MultipleFilesAttribute.addFileToList(akID, fileInfo);
            });
        }
        MultipleFilesAttribute.initListeners(akID, max_count, token);
    }
};


