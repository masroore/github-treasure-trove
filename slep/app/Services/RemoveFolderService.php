<?php
/*
    16.12.2019
    RolesService.php
*/

namespace App\Services;

use App\Models\Folder;

class RemoveFolderService
{
    public $foldersArray;

    public function __construct()
    {
        $this->foldersArray = [];
    }

    public function findFolderChildAnd($thisFolderId, $thisFolder): void
    {
        $this->foldersArray[] = $thisFolderId;
        $childs = Folder::where('folder_id', '=', $thisFolderId)->get();
        if (!empty($childs)) {
            foreach ($childs as $child) {
                $this->findFolderChildAnd($child->id, $thisFolder);
            }
        }
    }

    public function folderDelete($id, $thisFolder): void
    {
        $folder = Folder::where('id', '=', $id)->first();
        if ($folder->folder_id != null) {
            $this->foldersArray = [];
            $this->findFolderChildAnd($id, $thisFolder);
            foreach ($this->foldersArray as $folderId) {
                $folder = Folder::where('id', '=', $folderId)->first();
                $folder->delete();
            }
        }
    }
}
