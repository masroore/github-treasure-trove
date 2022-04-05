<div wire:ignore>
    
    <label class="col-sm-2 control-label" for=" ">내용</label>
    <div wire:ignore  class="col-sm-10">
        <div class=" border border-gray-600 ">
            <textarea class="w-full editor" 
            wire:model.lazy="content" name="content" id="mycontent"></textarea>
        </div>
        <div>
        @error('content') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>
    </div>
    
    {{-- <script defer src="/vendor/jquery-1.11.3.min.js"></script> --}}
    <script src="/assets/vendor/ckeditor2/ckeditor.js"></script>
    
    <script type="text/javascript">
        CKEDITOR.replace('content', {
            height: 250,
            //   filebrowserImageUploadUrl: '/upload'
            //   extraPlugins: 'colorbutton,colordialog'
            // extraPlugins: 'image2',

            filebrowserUploadUrl: "{{route('upload', ['_token' => csrf_token() ])}}",
            filebrowserUploadMethod: 'form'
        }).on('change', function(e){
            @this.set('content', e.editor.getData());
        });


    CKEDITOR.config.allowedContent = true;
    CKEDITOR.filebrowserUploadMethod = 'form';


    CKEDITOR.editorConfig = function( config ) {
    //     config.language = 'ko';
    //     config.extraPlugins = 'colorbutton';
            config.extraPlugins = 'colorbutton,colordialog,panelbutton';
    //     // config.extraPlugins = 'panelbutton';
        
    //     // config.uiColor = '#AADC6E';
    //         config.colorButton_colors =
    //     '000,800000,8B4513,2F4F4F,008080,000080,4B0082,696969,' +
    //     'B22222,A52A2A,DAA520,006400,40E0D0,0000CD,800080,808080,' +
    //     'F00,FF8C00,FFD700,008000,0FF,00F,EE82EE,A9A9A9,' +
    //     'FFA07A,FFA500,FFFF00,00FF00,AFEEEE,ADD8E6,DDA0DD,D3D3D3,' +
    //     'FFF0F5,FAEBD7,FFFFE0,F0FFF0,F0FFFF,F0F8FF,E6E6FA,FFF';
    };

    CKEDITOR.on( 'dialogDefinition', function( ev )
    {
        var dialogName = ev.data.name;
        var dialogDefinition = ev.data.definition;

        if (dialogName == 'image') {

            // Get the advanced tab reference
            var infoTab2 = dialogDefinition.getContents('advanced');

            //Set the default

            // Remove the 'Advanced' tab completely
            dialogDefinition.removeContents('advanced');


            // Get the properties tab reference
            var infoTab = dialogDefinition.getContents('info');

            // Remove unnecessary bits from this tab
            infoTab.remove('txtBorder');
            infoTab.remove('cmbAlign');
            infoTab.remove('txtWidth');
            infoTab.remove('txtHeight');
            infoTab.remove('txtCellSpace');
            infoTab.remove('txtCellPad');
            infoTab.remove('txtCaption');
            infoTab.remove('txtSummary');
        }
    });
    </script>

  
    
    </div>