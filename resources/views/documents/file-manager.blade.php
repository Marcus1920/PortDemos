@extends('master')

@section('content')
        
            <!-- Content -->
         
           
   
                <!-- Breadcrumb -->
                <ol class="breadcrumb hidden-xs">
                    <li><a href="#">Home</a></li>
                    <li><a href="#">Library</a></li>
                    <li class="active">Data</li>
                </ol>
                
                <h4 class="page-title">FILE MANAGER</h4>
                                
                <div id="fileManager" class="ui-helper-reset ui-helper-clearfix ui-widget ui-widget-content ui-corner-all elfinder elfinder-ltr elfinder-disabled" style="width: 100%; height: 500px;"><div class="ui-helper-clearfix ui-widget-header ui-corner-top elfinder-toolbar">
          
                <div class="elfinder-workzone" style="height: 442px;">

                <div class="ui-helper-clearfix ui-widget-header ui-corner-top elfinder-toolbar"><div style="display: block;" class="ui-widget-content elfinder-button elfinder-button-search"><input size="42" class="file-search" type="text"><span class="ui-icon ui-icon-search tooltips" title="" data-original-title="Search"></span><span class="ui-icon ui-icon-close icon-close">×</span></div><div class="ui-widget-content ui-corner-all elfinder-buttonset"><div class="ui-state-default elfinder-button tooltips ui-state-disabled" title="" data-original-title="Back"><span class="elfinder-button-icon elfinder-button-icon-back"></span></div><span class="ui-widget-content elfinder-toolbar-button-separator"></span><div class="ui-state-default elfinder-button tooltips ui-state-disabled" title="" data-original-title="Forward"><span class="elfinder-button-icon elfinder-button-icon-forward"></span></div><span class="ui-widget-content elfinder-toolbar-button-separator"></span><div class="ui-state-default elfinder-button tooltips ui-state-disabled" title="" data-original-title="Home"><span class="elfinder-button-icon elfinder-button-icon-home"></span></div><span class="ui-widget-content elfinder-toolbar-button-separator"></span><div class="ui-state-default elfinder-button tooltips ui-state-disabled" title="" data-original-title="Reload"><span class="elfinder-button-icon elfinder-button-icon-reload"></span></div></div><div class="ui-widget-content ui-corner-all elfinder-buttonset"><div class="ui-state-default elfinder-button tooltips ui-state-disabled" title="" data-original-title="New folder"><span class="elfinder-button-icon elfinder-button-icon-mkdir"></span></div><span class="ui-widget-content elfinder-toolbar-button-separator"></span><div class="ui-state-default elfinder-button tooltips ui-state-disabled" title="" data-original-title="New text file"><span class="elfinder-button-icon elfinder-button-icon-mkfile"></span></div><span class="ui-widget-content elfinder-toolbar-button-separator"></span><div class="ui-state-default elfinder-button tooltips ui-state-disabled" title="" data-original-title="Upload files"><span class="elfinder-button-icon elfinder-button-icon-upload"></span><form style="display: none;"><input multiple="true" type="file"></form></div></div><div class="ui-widget-content ui-corner-all elfinder-buttonset"><div class="ui-state-default elfinder-button tooltips ui-state-disabled" title="" data-original-title="View"><span class="elfinder-button-icon elfinder-button-icon-view"></span></div><span class="ui-widget-content elfinder-toolbar-button-separator"></span><div class="ui-state-default elfinder-button tooltips elfinder-menubutton elfiner-button-sort ui-state-disabled" title="" data-original-title="Sort"><span class="elfinder-button-icon elfinder-button-icon-sort"></span><div class="ui-widget ui-widget-content elfinder-button-menu fadeIn animated ui-corner-all" style="display: none; z-index: 12;"><div class="elfinder-button-menu-item elfinder-button-menu-item-selected elfinder-button-menu-item-selected-asc" rel="name"><span class="ui-icon ui-icon-arrowthick-1-n"></span><span class="ui-icon ui-icon-arrowthick-1-s"></span>by name</div><div class="elfinder-button-menu-item" rel="size"><span class="ui-icon ui-icon-arrowthick-1-n"></span><span class="ui-icon ui-icon-arrowthick-1-s"></span>by size</div><div class="elfinder-button-menu-item" rel="kind"><span class="ui-icon ui-icon-arrowthick-1-n"></span><span class="ui-icon ui-icon-arrowthick-1-s"></span>by kind</div><div class="elfinder-button-menu-item" rel="date"><span class="ui-icon ui-icon-arrowthick-1-n"></span><span class="ui-icon ui-icon-arrowthick-1-s"></span>by date</div><div class="elfinder-button-menu-item elfinder-button-menu-item-separated elfinder-button-menu-item-selected"><span class="ui-icon ui-icon-check"></span>Folders first</div></div></div></div></div>

                    <div class="ui-state-default elfinder-navbar ui-resizable" style="display: block; height: 442px; overflow: hidden;" tabindex="5003">
                       <div class="ui-resizable-handle ui-resizable-e" style="z-index: 10;">  </div>
                       <div class="elfinder-tree"> gfhgfh </div>
                    </div>


                    <div class="elfinder-cwd-wrapper" style="height: 462px; overflow: hidden;" tabindex="5004"> 
                      <div class="ui-helper-clearfix elfinder-cwd ui-selectable ui-droppable" unselectable="on"> Add Folder  
                      </div>
                   </div>

                </div>


                <div class="ui-widget-overlay elfinder-overlay" style="display: none; z-index: 11;">  </div>



                <div class="ui-dialog ui-widget ui-widget-content ui-corner-all ui-draggable bounceIn animated std42-dialog  elfinder-dialog elfinder-dialog-notify" style="display: none; width: 280px; height: auto; top: 12px; right: 12px;"><div class="ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix"><a href="#" class="ui-dialog-titlebar-close ui-corner-all"><span class="ui-icon ui-icon-closethick">×</span></a>&nbsp;</div><div class="ui-dialog-content ui-widget-content"></div></div>

                <div class="ui-widget-header ui-helper-clearfix ui-corner-bottom elfinder-statusbar" style="">
                    <div class="elfinder-stat-size"></div>
                    <div class="elfinder-path">&nbsp;</div>
                    <div class="elfinder-stat-selected">  </div>
                </div>
                </div>
         
     
         @endsection

        @section('footer')

        @endsection
        
       