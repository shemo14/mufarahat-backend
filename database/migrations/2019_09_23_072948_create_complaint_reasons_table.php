<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComplaintReasonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('complaint_reasons', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name_ar');
            $table->string('name_en');
            $table->timestamps();
        });

        $reason2 = new ComplaintReason;
        $reason2->name_ar = 'اساءه المعامله ';
        $reason2->name_en = 'Abuse';
        $reason2->save(); 

        $reason3 = new ComplaintReason;
        $reason3->name_ar = 'غلطه بالطلب';
        $reason3->name_en = 'order mistake';
        $reason3->save();

        $reason4  = new ComplaintReason;
        $reason4->name_ar = 'العميل تأخر في الطلب';
        $reason4->name_en = 'Customer delayed the order';
        $reason4->save();

        $reason = new ComplaintReason;
        $reason->name_ar = 'اسباب اخري';
        $reason->name_en = 'other reasons';
        $reason->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('complaint_reasons');
    }
}
