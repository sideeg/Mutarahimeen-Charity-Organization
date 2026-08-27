<?php
// ============================================================
//  app/Models/DashboardUser.php
// ============================================================
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DashboardUser extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $guarded  = ['id'];
    protected $hidden   = ['password_hash'];

    public function createdBy(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(DashboardUser::class, 'created_by');
    }

    public function articles(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(NewsArticle::class, 'author_id');
    }
}
