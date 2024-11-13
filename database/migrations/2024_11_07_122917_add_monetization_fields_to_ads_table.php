<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMonetizationFieldsToAdsTable extends Migration
{
    public function up()
    {
        Schema::table('ads', function (Blueprint $table) {
            $table->decimal('cpc_rate', 8, 3)->default(0)->after('active'); // Cost per click
            $table->decimal('cpm_rate', 8, 3)->default(0)->after('cpc_rate'); // Cost per 1000 views
            $table->boolean('use_cpc')->default(false)->after('cpm_rate');
            $table->boolean('use_cpm')->default(false)->after('use_cpc'); 
            $table->decimal('revenue', 10, 5)->default(0)->after('use_cpm'); 
            $table->decimal('bill', 10, 5)->default(0.00); 
            $table->text('description')->nullable()->after('ad_url'); 
            $table->boolean('paid_status')->default(false); 
        
            
        });
    }

    public function down()
    {
        Schema::table('ads', function (Blueprint $table) {
            $table->dropColumn(['cpc_rate', 'cpm_rate', 'use_cpc', 'use_cpm', 'revenue','bill', 'description', 'paid_status']);
           
        });
    }
}
