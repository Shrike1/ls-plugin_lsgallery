<?php

class PluginLsgallery extends Plugin
{

    public $aInherits = array(
        'action' => array(
            'ActionProfile' => '_ActionProfile'
        ),
        'module' => array(
            'ModuleACL' => '_ModuleACL',
            'ModuleRating' => '_ModuleRating',
            'ModuleUser' => '_ModuleUser'
        ),
        'mapper' => array(
            'ModuleUser_MapperUser' => '_ModuleUser_MapperUser'
        ),
    );
    protected $aDelegates = array(
        'template' => array(
            'menu.album_edit.tpl',
            'menu.album.tpl',
            'photo_view.tpl',
            'photo_list.tpl',
            'block.random_images.tpl',
            'block.albums_list.tpl'
        )
    );

    /**
     * Активация плагина
     *
     * @return boolean
     */
    public function Activate()
    {
        $this->Cache_Clean();
        if (!$this->isTableExists('prefix_lsgallery_album')) {
            $this->addEnumType(Config::Get('db.table.comment'), 'target_type', 'image');
            $this->addEnumType(Config::Get('db.table.vote'), 'target_type', 'image');
            $this->addEnumType(Config::Get('db.table.favourite'), 'target_type', 'image');
            $resutls = $this->ExportSQL(dirname(__FILE__) . '/activate.sql');
            return $resutls['result'];
        }
        
        return true;
    }

    /**
     * Инициализация плагина
     *
     * @return void
     */
    public function Init()
    {
        $this->Viewer_Assign("sTemplateWebPathLsgallery", Plugin::GetTemplateWebPath(__CLASS__));
    }

    /**
     * Деактивация плагина
     *
     * @return boolean
     */
    public function Deactivate()
    {
        $this->Cache_Clean();
        return true;
    }

}