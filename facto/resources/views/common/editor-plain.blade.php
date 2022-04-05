<div wire:ignore>
     
    <label class="col-sm-2 control-label" for=" ">내용</label>
    <div wire:ignore  class="col-sm-10">
        <div class=" border border-gray-600 ">
            <textarea 
                wire:ignore
                class="w-full ckeditor" 
                wire:model.lazy="content" name="content" id="mycontent"></textarea>
        </div>
        <div>
        @error('content') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>
    </div>
    
    
    {{-- <script src="https://cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script> --}}
    <script>
        $(document).ready(function() {
            $('.ckeditor').ckeditor();
        });
    </script>
    
    {{-- <script type="text/javascript">
        CKEDITOR.replace('.ckeditor', {
            height: 250,
            filebrowserUploadUrl: "{{route('upload', ['_token' => csrf_token() ])}}",
            filebrowserUploadMethod: 'form'
        }).on('change', function(e){
            @this.set('content', e.editor.getData());
        });
    
    CKEDITOR.config.allowedContent = true;
    CKEDITOR.filebrowserUploadMethod = 'form';
    
    
    CKEDITOR.editorConfig = function( config ) {
            config.extraPlugins = 'colorbutton,colordialog,panelbutton';
    };
    
    CKEDITOR.on( 'dialogDefinition', function( ev )
    {
        var dialogName = ev.data.name;
        var dialogDefinition = ev.data.definition;
    
        if (dialogName == 'image') {
            var infoTab2 = dialogDefinition.getContents('advanced');
            dialogDefinition.removeContents('advanced');
            var infoTab = dialogDefinition.getContents('info');
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
    
    </script> --}}

    {{-- 
    <div
    class="form-textarea w-full"
    x-data
    x-init="
        DecoupledEditor.create($refs.myIdentifierHere)
            .then( function(editor){
                editor.model.document.on('change:data', () => {
                $dispatch('input', editor.getData())
                })
            })
            .catch( error => {
                console.error( error );
            } );
        "
    wire:ignore
    wire:key="myIdentifierHere"
    x-ref="myIdentifierHere"
    wire:model.lazy="content"
    >{!! $content !!}</div>  --}}
    
    {{-- 
    <div wire:ignore class="col-sm-12">
        <span class="sound_only">웹에디터 시작</span>
        <textarea 
            wire:ignore 
            wire:model.lazy="content"
            id="wr_content" 
            name="wr_content" 
            class="ckeditor form-control input-sm write-content" 
            maxlength="65536" 
            style="visibility: hidden; display: none;"
            ></textarea>
        <span class="sound_only">웹 에디터 끝</span>
    </div>
    
    <script>
        CKEDITOR.replace('#wr_content').on('change', function(e){
            console.log(  e.editor.getData())
            @this.set('{{ $content }}', e.editor.getData());
        });
    </script> --}}
    
    {{-- <script>
    CKEDITOR.replace(’#wr_content).on(‘change’, function(e){
        @this.set(’{{ $content }}’, e.editor.getData());
    });
    </script>  --}}
    
    </div>