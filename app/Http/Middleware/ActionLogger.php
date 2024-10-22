<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\UserLog;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ActionLogger
{
    public function handle(Request $request, Closure $next)
    {
        // Cleanup old logs before processing the request
        $this->cleanupOldLogs();

        $response = $next($request);

        // Log detailed information after the request is processed
        $description = $this->generateDescription($request);

        // Check if the route exists before trying to get the controller
        if ($route = $request->route()) {
            $controller = class_basename($route->getController());
            $action = $route->getActionMethod();
        } else {
            // Handle the case when the route does not exist
            \Log::warning('No route found for the request.', [
                'url' => $request->fullUrl(),
                'method' => $request->method(),
            ]);
            $controller = 'unknown';
            $action = 'unknown';
        }

        UserLog::create([
            'user_id'   => auth()->check() ? auth()->id() : null,
            'controller'=> $controller,
            'action'    => $action,
            'url'       => $request->fullUrl(),
            'method'    => $request->method(),
            'ip'        => $request->ip(),
            'description'=> $description,
        ]);

        return $response;
    }

    private function cleanupOldLogs()
    {
        // Define the date threshold for old logs (1 month ago)
        $thresholdDate = Carbon::now()->subMonths(1);
        
        // Delete logs older than the threshold
        UserLog::where('created_at', '<', $thresholdDate)->delete();
    }

    private function generateDescription(Request $request)
    {
        // Check if the route exists before accessing it
        if (!$route = $request->route()) {
            return 'No route found for generating description';
        }

        $controller = class_basename($route->getController());
        $action = $route->getActionMethod();
        $description = '';

        // Map actions to descriptions
        switch ($controller) {
            case 'UserController':
                switch ($action) {
                    case 'index':
                        $description = 'المستخدم عرض قائمة المستخدمين. (عرض جميع المستخدمين)';
                        break;
                    case 'create':
                        $description = 'المستخدم عُرض نموذج إضافة مستخدم جديد. (بدء عملية إضافة مستخدم)';
                        break;
                    case 'store':
                        $description = 'المستخدم قام بإنشاء مستخدم جديد. (تم إضافة مستخدم: ' . $request->input('name') . ')';
                        break;
                    case 'edit':
                        $description = 'المستخدم عُرض نموذج تعديل المستخدم. (تحرير معلومات المستخدم: ' . $request->route('id') . ')';
                        break;
                    case 'update':
                        $description = 'المستخدم قام بتحديث معلومات المستخدم. (تم تحديث معلومات المستخدم: ' . $request->input('name') . ')';
                        break;
                    case 'destroy':
                        $description = 'المستخدم قام بحذف مستخدم. (تم حذف المستخدم: ' . $request->route('id') . ')';
                        break;
                }
                break;

            case 'AnimalController':
                switch ($action) {
                    case 'index':
                        $description = 'المستخدم عرض قائمة المواشي. (عرض جميع المواشي)';
                        break;
                    case 'create':
                        $description = 'المستخدم عُرض نموذج إضافة ماشية جديدة. (بدء عملية إضافة ماشية)';
                        break;
                    case 'store':
                        $description = 'المستخدم قام بإضافة ماشية جديدة. (تم إضافة ماشية: ' . $request->input('name') . ')';
                        break;
                    case 'edit':
                        $description = 'المستخدم عُرض نموذج تعديل الماشية. (تحرير معلومات الماشية: ' . $request->route('id') . ')';
                        break;
                    case 'update':
                        $description = 'المستخدم قام بتحديث معلومات الماشية. (تم تحديث معلومات الماشية: ' . $request->input('name') . ')';
                        break;
                    case 'destroy':
                        $description = 'المستخدم قام بحذف ماشية. (تم حذف ماشية: ' . $request->route('id') . ')';
                        break;
                }
                break;

            case 'CustomerController':
                switch ($action) {
                    case 'index':
                        $description = 'المستخدم عرض قائمة العملاء. (عرض جميع العملاء)';
                        break;
                    case 'create':
                        $description = 'المستخدم عُرض نموذج إضافة عميل جديد. (بدء عملية إضافة عميل)';
                        break;
                    case 'store':
                        $description = 'المستخدم قام بإنشاء عميل جديد. (تم إضافة عميل: ' . $request->input('name') . ')';
                        break;
                    case 'edit':
                        $description = 'المستخدم عُرض نموذج تعديل العميل. (تحرير معلومات العميل: ' . $request->route('id') . ')';
                        break;
                    case 'update':
                        $description = 'المستخدم قام بتحديث معلومات العميل. (تم تحديث معلومات العميل: ' . $request->input('name') . ')';
                        break;
                    case 'destroy':
                        $description = 'المستخدم قام بحذف عميل. (تم حذف عميل: ' . $request->route('id') . ')';
                        break;
                }
                break;

            case 'SaleController':
                switch ($action) {
                    case 'index':
                        $description = 'المستخدم عرض قائمة المبيعات. (عرض جميع المبيعات)';
                        break;
                    case 'create':
                        $description = 'المستخدم عُرض نموذج إضافة بيع جديد. (بدء عملية إضافة بيع)';
                        break;
                    case 'store':
                        $description = 'المستخدم قام بإنشاء بيع جديد. (تم إضافة بيع: ' . $request->input('sale_details') . ')';
                        break;
                    case 'edit':
                        $description = 'المستخدم عُرض نموذج تعديل البيع. (تحرير معلومات البيع: ' . $request->route('id') . ')';
                        break;
                    case 'update':
                        $description = 'المستخدم قام بتحديث معلومات البيع. (تم تحديث معلومات البيع: ' . $request->input('sale_details') . ')';
                        break;
                    case 'destroy':
                        $description = 'المستخدم قام بحذف بيع. (تم حذف بيع: ' . $request->route('id') . ')';
                        break;
                }
                break;

            case 'SupplierController':
                switch ($action) {
                    case 'index':
                        $description = 'المستخدم عرض قائمة الموردين. (عرض جميع الموردين)';
                        break;
                    case 'create':
                        $description = 'المستخدم عُرض نموذج إضافة مورد جديد. (بدء عملية إضافة مورد)';
                        break;
                    case 'store':
                        $description = 'المستخدم قام بإنشاء مورد جديد. (تم إضافة مورد: ' . $request->input('name') . ')';
                        break;
                    case 'edit':
                        $description = 'المستخدم عُرض نموذج تعديل المورد. (تحرير معلومات المورد: ' . $request->route('id') . ')';
                        break;
                    case 'update':
                        $description = 'المستخدم قام بتحديث معلومات المورد. (تم تحديث معلومات المورد: ' . $request->input('name') . ')';
                        break;
                    case 'destroy':
                        $description = 'المستخدم قام بحذف مورد. (تم حذف مورد: ' . $request->route('id') . ')';
                        break;
                }
                break;

            case 'ProfileController':
                switch ($action) {
                    case 'edit':
                        $description = 'المستخدم عُرض نموذج تعديل الملف الشخصي. (تحرير الملف الشخصي)';
                        break;
                    case 'update':
                        $description = 'المستخدم قام بتحديث معلومات الملف الشخصي. (تم تحديث معلومات الملف الشخصي)';
                        break;
                    case 'destroy':
                        $description = 'المستخدم قام بحذف حسابه. (تم حذف الحساب)';
                        break;
                }
                break;

            case 'DashboardController':
                switch ($action) {
                    case 'index':
                        $description = 'المستخدم عُرض لوحة القيادة مع ملخص البيانات والإحصاءات. (عرض البيانات والإحصاءات)';
                        break;
                }
                break;
            
            case 'AuthenticatedSessionController':
                switch ($action) {
                    case 'create':
                        $description = 'المستخدم عُرض نموذج تسجيل الدخول. (فتح صفحة تسجيل الدخول)';
                        break;
                    case 'store':
                        $description = 'المستخدم قام بتسجيل الدخول. (تم تسجيل دخول المستخدم: ' . $request->input('email') . ')';
                        break;
                    case 'destroy':
                        $description = 'المستخدم قام بتسجيل الخروج. (تم تسجيل خروج المستخدم)';
                        break;
                }
                break;
        }

        // Fallback description if no specific case is matched
        if (empty($description)) {
            $description = "تم تنفيذ إجراء في المتحكم $controller.";
        }

        return $description;
    }
}
