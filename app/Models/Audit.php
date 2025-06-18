 <?php
 // app/Models/Audit.php
use App\Models;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Audit extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $fillable = ['user_id', 'event', 'auditable_type', 'auditable_id', 'old_values', 'new_values', 'url', 'ip_address'];

    // You can customize the attributes to include or exclude as needed.
    protected $auditExclude = ['password']; // Exclude sensitive data
}
