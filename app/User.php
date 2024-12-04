<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function getpermissionGroups()
    {
        $permission_groups = DB::table('permissions')
            ->select('group_name as name')
            ->groupBy('group_name')
            ->get();
        return $permission_groups;
    }

    public static function getpermissionsByGroupName($group_name)
    {
        $permissions = DB::table('permissions')
            ->select('name', 'id')
            ->where('group_name', $group_name)
            ->get();
        return $permissions;
    }

    public static function roleHasPermissions($role, $permissions)
    {
        $hasPermission = true;
        foreach ($permissions as $permission) {
            if (!$role->hasPermissionTo($permission->name)) {
                $hasPermission = false;
                return $hasPermission;
            }
        }
        return $hasPermission;
    }

    function getInitials($name) {
        $words = explode(' ', $name);
        $initials = '';
        foreach ($words as $word) {
            $initials .= strtoupper($word[0]);
        }
        return $initials;
    }
    function getPercentDocumentProject($project_id){
        // Ambil kategori dokumen yang aktif dan belum dihapus
        $documentCat = \App\Models\CategoryDocument::where('deleted_at', null)->where('status', 1)->get();
        $documentRumus = \App\Models\DocumentProject::where('id_project', $project_id->id)->get();


        // Hitung jumlah dokumen yang sesuai dengan kategori dokumen
        $countDoc = 0;
        if ($documentRumus->count() > 0) {
            foreach ($documentCat as $dcr) {
                // Ambil dokumen proyek yang diunggah oleh pengguna
                $documentExist = \App\Models\DocumentProject::where('id_project', $project_id->id)->where('id_category',$dcr->id)->first();
                if ($documentExist != null) {
                    $countDoc += 1;
                }
            }
        }
        // Total kategori dokumen
        $totalDocumentCategories = $documentCat->count();
        // Hitung persentase
        $documentPercentage = ($countDoc / $totalDocumentCategories) * 20;
        return $documentPercentage;
    }
    
}
