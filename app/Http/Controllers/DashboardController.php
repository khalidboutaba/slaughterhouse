<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Animal;
use App\Models\Sale;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;





class DashboardController extends Controller
{
    public function index()
    {
        $quantityMap = [
            '1/4' => 0.25,
            '1/2' => 0.5,
            '3/4' => 0.75,
            '1' => 1,
        ];
        //$fullySoldAnimals = Animal::where('sold_status', 'fully_sold')->count();

        $fullySoldAnimalsToday = $this->getFullySoldAnimalsToday();
        $totalRevenueToday = $this->getTotalRevenueToday();
        $numberOfSoldAnimals = $this->getNumberOfSoldAnimals();
        $animalsAddedToday = $this->getAnimalsAddedToday();
        $salesToday = $this->getSalesToday();
        $topCustomers = $this->getTopCustomers();
        $salesByAnimalType = $this->getSalesByAnimalType();
        $monthlySalesData = $this->getSalesByMonth();

        return view('dashboard', compact('quantityMap','fullySoldAnimalsToday', 'totalRevenueToday', 'numberOfSoldAnimals', 'animalsAddedToday', 'salesToday', 'topCustomers', 'salesByAnimalType', 'monthlySalesData'));
    }

    private function getFullySoldAnimalsToday()
    {
        // Get today's date
        $today = Carbon::today();

        // Get the IDs of animals sold today
        $soldToday = Sale::whereDate('sale_date', $today)->pluck('animal_id')->unique();

        // Count the number of fully sold animals based on today's sales
        return Animal::whereIn('id', $soldToday)->where('sold_status', 'fully_sold')->count();
    }

    private function getNumberOfSoldAnimals()
    {
        // Get the start and end of today
        $todayStart = now()->startOfDay();
        $todayEnd = now()->endOfDay();

        // Get the IDs of animals that have been sold today
        $soldAnimalIds = Sale::whereBetween('sale_date', [$todayStart, $todayEnd])
                            ->pluck('animal_id')
                            ->unique();

        // Count the number of unique animals with sales
        return Animal::whereIn('id', $soldAnimalIds)->count();
    }

    private function getTotalRevenueToday()
    {
        // Get today's date
        $today = Carbon::today();

        // Calculate the total revenue for today's sales
        return Sale::whereDate('sale_date', $today)->sum('total_price');
    }

    private function getAnimalsAddedToday()
    {
        // Get today's date
        $today = Carbon::today();

        // Count the number of animals added today
        return Animal::whereDate('created_at', $today)->count();
    }

    private function getSalesToday()
    {
        // Get today's date
        $today = Carbon::today();

        // Fetch all sales records for today
        return Sale::whereDate('sale_date', $today)->with('animal', 'customer')->get();
    }

    private function getTopCustomers()
    {
        // Fetch top 3 customers with the highest number of sales
        $topCustomers = Sale::select('customer_id', DB::raw('count(*) as total_sales'))
                            ->groupBy('customer_id')
                            ->orderBy('sale_date', 'desc')
                            ->with('customer') // Assuming you have a relationship between Sale and Customer
                            ->get();

        return $topCustomers;
    }

    private function getSalesByAnimalType()
    {
        return Animal::select('type', DB::raw('count(*) as total_sales'))
                    ->join('sales', 'animals.id', '=', 'sales.animal_id')
                    ->groupBy('type')
                    ->pluck('total_sales', 'type'); // Get data as key-value pairs
    }

    private function getSalesByMonth()
    {
        // Get sales data for the last 12 months
        return Sale::select(
                    DB::raw('DATE_FORMAT(sale_date, "%Y-%m") as month_year'),
                    DB::raw('count(*) as total_sales')
                )
                ->where('sale_date', '>=', Carbon::now()->subMonths(12))
                ->groupBy(DB::raw('DATE_FORMAT(sale_date, "%Y-%m")'))
                ->orderBy(DB::raw('DATE_FORMAT(sale_date, "%Y-%m")'), 'asc')
                ->get()
                ->pluck('total_sales', 'month_year');
    }
}
