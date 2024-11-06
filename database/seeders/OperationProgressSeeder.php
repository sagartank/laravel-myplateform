<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Ramsey\Uuid\Uuid as PackageUuid;
use App\Models\OperationProgress;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class OperationProgressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('operation_progress')->truncate();

        /* $progress = [
                [
                'step_type' => 'Seller', 'slug' => PackageUuid::uuid4()->toString(),
                'title_en' => 'Offer accepted, Sign Contract',
                'title_es' => 'Oferta aceptada, Firmar Contrato',
                'description' => '','cashed' => 'No','rate'=> 'No', 'is_active' => 'Yes', 'order_position' => '1'],

                [
                'step_type' => 'Seller', 'slug' => PackageUuid::uuid4()->toString(),
                'title_en' => 'Send document to MIPO',
                'title_es' => 'Enviar documento a MIPO',
                'description' => '','cashed' => 'No','rate'=> 'No', 'is_active' => 'Yes', 'order_position' => '2'],

                [
                'step_type' => 'Seller', 'slug' => PackageUuid::uuid4()->toString(),
                'title_en' => 'Document in custody, in process of Back End Validation',
                'title_es' => 'Documento en custodia, en proceso de Verificación',
                'description' => '','cashed' => 'No','rate'=> 'No', 'is_active' => 'Yes', 'order_position' => '3'],

                [
                'step_type' => 'Seller', 'slug' => PackageUuid::uuid4()->toString(),
                'title_en' => 'Documents Verified, Transfer allowed and awaiting',
                'title_es' => 'Documentos Verificados, Transferencia permitida y en espera',
                'description' => '','cashed' => 'No','rate'=> 'No', 'is_active' => 'Yes', 'order_position' => '4'],

                [
                'step_type' => 'Seller', 'slug' => PackageUuid::uuid4()->toString(),
                'title_en' => 'Payment received by buyer',
                'title_es' => 'Pago recibido por el comprador',
                'description' => '','cashed' => 'Yes','rate'=> 'No', 'is_active' => 'Yes', 'order_position' => '5'],

                [
                'step_type' => 'Buyer', 'slug' => PackageUuid::uuid4()->toString(),
                'title_en' => 'Offer accepted, Digital Signature Needed',
                'title_es' => 'Oferta aceptada, Requiere Firma Digital',
                'description' => '','cashed' => 'No','rate'=> 'No', 'is_active' => 'Yes', 'order_position' => '1'],

                [
                'step_type' => 'Buyer', 'slug' => PackageUuid::uuid4()->toString(),
                'title_en' => 'Awaiting Seller Documents',
                'title_es' => 'En espera de documentos del vendedor',
                'description' => '','cashed' => 'No','rate'=> 'No', 'is_active' => 'Yes', 'order_position' => '2'],

                [
                'step_type' => 'Buyer', 'slug' => PackageUuid::uuid4()->toString(),
                'title_en' => 'Documents in Custody, Awaiting MIPO Verification',
                'title_es' => 'Documentos en Custodia Aguardando Verificacion de MIPO',
                'description' => '','cashed' => 'No','rate'=> 'No', 'is_active' => 'Yes', 'order_position' => '3'],

                [
                'step_type' => 'Buyer', 'slug' => PackageUuid::uuid4()->toString(),
                'title_en' => 'Documents Verified',
                'title_es' => 'Documentos Verificados',
                'description' => '','cashed' => 'No','rate'=> 'No', 'is_active' => 'Yes', 'order_position' => '4'],

                [
                'step_type' => 'Buyer', 'slug' => PackageUuid::uuid4()->toString(),
                'title_en' => 'MIPO Commission Payment',
                'title_es' => 'Pago de Comisión a MIPO',
                'description' => '','cashed' => 'No','rate'=> 'No', 'is_active' => 'Yes', 'order_position' => '5'],

                [
                'step_type' => 'Buyer', 'slug' => PackageUuid::uuid4()->toString(),
                'title_en' => 'Funds Transfer to Seller',
                'title_es' => 'Transferencia/Pago a Vendedor',
                'description' => '','cashed' => 'No','rate'=> 'No', 'is_active' => 'Yes', 'order_position' => '6'],

                [
                'step_type' => 'Buyer', 'slug' => PackageUuid::uuid4()->toString(),
                'title_en' => 'Documents availabel for pickup / request delivery',
                'title_es' => 'Documentos disponibles para recogida/solicitud de entrega',
                'description' => '','cashed' => 'No','rate'=> 'No', 'is_active' => 'Yes', 'order_position' => '7'],

                [
                'step_type' => 'Buyer', 'slug' => PackageUuid::uuid4()->toString(),
                'title_en' => 'Documents delivered',
                'title_es' => 'Documentos entregados',
                'description' => '','cashed' => 'No','rate'=> 'No', 'is_active' => 'Yes', 'order_position' => '8'],

                [
                'step_type' => 'Buyer', 'slug' => PackageUuid::uuid4()->toString(),
                'title_en' => 'Documents Cashed / Issue detected',
                'title_es' => 'Documentos Cobrados / Emisión detectada',
                'description' => '','cashed' => 'Yes','rate'=> 'Yes', 'is_active' => 'Yes', 'order_position' => '9']
            ]; */
        
         /*    $operation_progress = array(
                array('id' => '1','slug' => '71027771-c04d-464d-9590-1e40c94d3c02','step_type' => 'Seller','step_links' => NULL,'title_en' => 'Offer accepted, Sign Contract','title_es' => 'Oferta aceptada, Firmar Contrato','description' => NULL,'cashed' => 'No','rate' => 'No','file_upload' => 'No','qr_code' => 'No','payment' => 'No','mipo_commission_payment' => 'No','is_active' => 'Yes','order_position' => '1','created_by' => NULL,'updated_by' => NULL,'created_at' => NULL,'updated_at' => '2023-05-12 05:08:51','deleted_at' => NULL,'manual_trigger' => 'None'),
                array('id' => '2','slug' => 'c86d93fc-948d-4648-82db-3f99a20d7a3a','step_type' => 'Seller','step_links' => NULL,'title_en' => 'Send document to MIPO','title_es' => 'Enviar documento a MIPO','description' => NULL,'cashed' => 'No','rate' => 'No','file_upload' => 'No','qr_code' => 'No','payment' => 'No','mipo_commission_payment' => 'No','is_active' => 'Yes','order_position' => '2','created_by' => NULL,'updated_by' => NULL,'created_at' => NULL,'updated_at' => '2023-06-19 06:54:15','deleted_at' => NULL,'manual_trigger' => 'None'),
                array('id' => '3','slug' => '2b0dffec-0ea0-4132-aec8-76217a393d8e','step_type' => 'Seller','step_links' => '["8","9","10"]','title_en' => 'Document in custody, in process of Back End Validation','title_es' => 'Documento en custodia, en proceso de Verificación','description' => NULL,'cashed' => 'No','rate' => 'No','file_upload' => 'No','qr_code' => 'No','payment' => 'No','mipo_commission_payment' => 'No','is_active' => 'Yes','order_position' => '3','created_by' => NULL,'updated_by' => NULL,'created_at' => NULL,'updated_at' => '2023-06-19 06:54:25','deleted_at' => NULL,'manual_trigger' => 'Admin'),
                array('id' => '4','slug' => '4c9d0131-89ab-4b3a-98b5-223b3c3970b9','step_type' => 'Seller','step_links' => '["4","5","15","12"]','title_en' => 'Documents Verified, Transfer allowed and awaiting','title_es' => 'Documentos Verificados, Transferencia permitida y en espera','description' => NULL,'cashed' => 'No','rate' => 'No','file_upload' => 'No','qr_code' => 'Yes','payment' => 'No','mipo_commission_payment' => 'No','is_active' => 'Yes','order_position' => '4','created_by' => NULL,'updated_by' => NULL,'created_at' => NULL,'updated_at' => '2023-06-17 06:21:09','deleted_at' => NULL,'manual_trigger' => 'None'),
                array('id' => '5','slug' => '30a5695c-ca16-4bdf-abf8-7dafe1578adc','step_type' => 'Seller','step_links' => '["15","12"]','title_en' => 'Payment confirmation pending','title_es' => 'Pendiente confirmacion cobro','description' => NULL,'cashed' => 'Yes','rate' => 'No','file_upload' => 'No','qr_code' => 'No','payment' => 'No','mipo_commission_payment' => 'No','is_active' => 'Yes','order_position' => '5','created_by' => NULL,'updated_by' => NULL,'created_at' => NULL,'updated_at' => '2023-06-17 06:15:13','deleted_at' => NULL,'manual_trigger' => 'None'),
                array('id' => '6','slug' => 'eaa4bc96-63d3-4be2-92b2-bafc3e6ce754','step_type' => 'Buyer','step_links' => NULL,'title_en' => 'Offer accepted, Digital Signature Needed','title_es' => 'Oferta aceptada, Requiere Firma Digital','description' => NULL,'cashed' => 'No','rate' => 'No','file_upload' => 'No','qr_code' => 'No','payment' => 'No','mipo_commission_payment' => 'No','is_active' => 'Yes','order_position' => '1','created_by' => NULL,'updated_by' => NULL,'created_at' => NULL,'updated_at' => '2023-05-12 05:02:29','deleted_at' => NULL,'manual_trigger' => 'None'),
                array('id' => '7','slug' => '7e81968e-3016-4d00-9a76-8a032e760bab','step_type' => 'Buyer','step_links' => NULL,'title_en' => 'Awaiting Seller Documents','title_es' => 'En espera de documentos del vendedor','description' => '','cashed' => 'No','rate' => 'No','file_upload' => 'No','qr_code' => 'No','payment' => 'No','mipo_commission_payment' => 'No','is_active' => 'Yes','order_position' => '2','created_by' => NULL,'updated_by' => NULL,'created_at' => NULL,'updated_at' => NULL,'deleted_at' => NULL,'manual_trigger' => 'None'),
                array('id' => '8','slug' => '991074c0-9d3e-49df-af34-f33f8dc8fbf5','step_type' => 'Buyer','step_links' => '["4"]','title_en' => 'Documents in Custody, Awaiting MIPO Verification','title_es' => 'Documentos en Custodia Aguardando Verificacion de MIPO','description' => NULL,'cashed' => 'No','rate' => 'No','file_upload' => 'No','qr_code' => 'No','payment' => 'No','mipo_commission_payment' => 'No','is_active' => 'Yes','order_position' => '3','created_by' => NULL,'updated_by' => NULL,'created_at' => NULL,'updated_at' => '2023-06-19 05:15:45','deleted_at' => NULL,'manual_trigger' => 'None'),
                array('id' => '9','slug' => 'ee279bd9-dbb5-44e7-aa4a-bd3bcc3e1166','step_type' => 'Buyer','step_links' => NULL,'title_en' => 'Documents Verified','title_es' => 'Documentos Verificados','description' => NULL,'cashed' => 'No','rate' => 'No','file_upload' => 'No','qr_code' => 'No','payment' => 'No','mipo_commission_payment' => 'No','is_active' => 'Yes','order_position' => '4','created_by' => NULL,'updated_by' => NULL,'created_at' => NULL,'updated_at' => '2023-06-15 06:04:38','deleted_at' => NULL,'manual_trigger' => 'None'),
                array('id' => '10','slug' => '5773320b-37ad-4dc0-a9f0-b2e5544ade8c','step_type' => 'Buyer','step_links' => '["11"]','title_en' => 'MIPO Commission Payment','title_es' => 'Pago de Comisión a MIPO','description' => NULL,'cashed' => 'No','rate' => 'No','file_upload' => 'No','qr_code' => 'No','payment' => 'No','mipo_commission_payment' => 'Yes','is_active' => 'Yes','order_position' => '5','created_by' => NULL,'updated_by' => NULL,'created_at' => NULL,'updated_at' => '2023-06-19 05:27:20','deleted_at' => NULL,'manual_trigger' => 'Admin'),
                array('id' => '11','slug' => '0ca0a3c2-832f-48d6-8c24-1b5a5974246d','step_type' => 'Buyer','step_links' => '["4","5"]','title_en' => 'Funds Transfer to Seller','title_es' => 'Transferencia/Pago a Vendedor','description' => NULL,'cashed' => 'No','rate' => 'No','file_upload' => 'Yes','qr_code' => 'No','payment' => 'Yes','mipo_commission_payment' => 'No','is_active' => 'Yes','order_position' => '6','created_by' => NULL,'updated_by' => NULL,'created_at' => NULL,'updated_at' => '2023-06-19 08:26:33','deleted_at' => NULL,'manual_trigger' => 'None'),
                array('id' => '12','slug' => '1c12f963-43e9-4196-adaf-930e2f110af8','step_type' => 'Buyer','step_links' => NULL,'title_en' => 'Documents availabel for pickup / request delivery','title_es' => 'Documentos disponibles para recogida/solicitud de entrega','description' => NULL,'cashed' => 'No','rate' => 'No','file_upload' => 'No','qr_code' => 'Yes','payment' => 'No','mipo_commission_payment' => 'No','is_active' => 'Yes','order_position' => '7','created_by' => NULL,'updated_by' => NULL,'created_at' => NULL,'updated_at' => '2023-05-15 22:47:24','deleted_at' => NULL,'manual_trigger' => 'None'),
                array('id' => '13','slug' => '845f18fe-41a7-4978-b2dc-79fa819f2bb2','step_type' => 'Buyer','step_links' => NULL,'title_en' => 'Documents delivered','title_es' => 'Documentos entregados','description' => '','cashed' => 'No','rate' => 'No','file_upload' => 'No','qr_code' => 'No','payment' => 'No','mipo_commission_payment' => 'No','is_active' => 'Yes','order_position' => '8','created_by' => NULL,'updated_by' => NULL,'created_at' => NULL,'updated_at' => NULL,'deleted_at' => NULL,'manual_trigger' => 'None'),
                array('id' => '14','slug' => '436a8008-b9f9-450e-aa63-aa2bd9218c39','step_type' => 'Buyer','step_links' => NULL,'title_en' => 'Documents Cashed / Issue detected','title_es' => 'Documentos Cobrados / Emisión detectada','description' => NULL,'cashed' => 'Yes','rate' => 'Yes','file_upload' => 'No','qr_code' => 'No','payment' => 'No','mipo_commission_payment' => 'No','is_active' => 'Yes','order_position' => '9','created_by' => NULL,'updated_by' => NULL,'created_at' => NULL,'updated_at' => '2023-05-12 04:33:27','deleted_at' => NULL,'manual_trigger' => 'None'),
                array('id' => '15','slug' => '913180e9-3ea2-4735-a9e7-3e460d2e3063','step_type' => 'Seller','step_links' => NULL,'title_en' => 'Collection received by seller','title_es' => 'Cobro recibido por vendedor','description' => 'Cobro recibido por
                    vendedor','cashed' => 'No','rate' => 'No','file_upload' => 'No','qr_code' => 'No','payment' => 'No','mipo_commission_payment' => 'No','is_active' => 'Yes','order_position' => '6','created_by' => '1','updated_by' => '1','created_at' => '2023-06-17 06:13:39','updated_at' => '2023-06-17 06:14:02','deleted_at' => NULL,'manual_trigger' => 'None')
              ); */
        
            $operation_progress = array(
                array('id' => '1','slug' => '71027771-c04d-464d-9590-1e40c94d3c02','step_type' => 'Seller','step_links' => NULL,'title_en' => 'Offer accepted, Sign Contract','title_es' => 'Oferta aceptada, Firmar Contrato','description' => NULL,'cashed' => 'No','rate' => 'No','file_upload' => 'No','qr_code' => 'No','payment' => 'No','mipo_commission_payment' => 'No','is_active' => 'Yes','order_position' => '1','created_by' => NULL,'updated_by' => NULL,'created_at' => NULL,'updated_at' => '2023-05-12 05:08:51','deleted_at' => NULL,'manual_trigger' => 'None'),
                array('id' => '2','slug' => 'c86d93fc-948d-4648-82db-3f99a20d7a3a','step_type' => 'Seller','step_links' => NULL,'title_en' => 'Send document to MIPO','title_es' => 'Enviar documento a MIPO','description' => NULL,'cashed' => 'No','rate' => 'No','file_upload' => 'No','qr_code' => 'No','payment' => 'No','mipo_commission_payment' => 'No','is_active' => 'Yes','order_position' => '2','created_by' => NULL,'updated_by' => NULL,'created_at' => NULL,'updated_at' => '2023-06-19 06:54:15','deleted_at' => NULL,'manual_trigger' => 'None'),
                array('id' => '3','slug' => '2b0dffec-0ea0-4132-aec8-76217a393d8e','step_type' => 'Seller','step_links' => '["8"]','title_en' => 'Document in custody, in process of Back End Validation','title_es' => 'Documento en custodia, en proceso de Verificación','description' => NULL,'cashed' => 'No','rate' => 'No','file_upload' => 'No','qr_code' => 'No','payment' => 'No','mipo_commission_payment' => 'No','is_active' => 'Yes','order_position' => '3','created_by' => NULL,'updated_by' => NULL,'created_at' => NULL,'updated_at' => '2023-06-29 06:44:20','deleted_at' => NULL,'manual_trigger' => 'Admin'),
                array('id' => '4','slug' => '4c9d0131-89ab-4b3a-98b5-223b3c3970b9','step_type' => 'Seller','step_links' => '["9","10"]','title_en' => 'Documents Verified, Transfer allowed and awaiting','title_es' => 'Documentos Verificados, Transferencia permitida y en espera','description' => NULL,'cashed' => 'No','rate' => 'No','file_upload' => 'No','qr_code' => 'Yes','payment' => 'No','mipo_commission_payment' => 'No','is_active' => 'Yes','order_position' => '4','created_by' => NULL,'updated_by' => NULL,'created_at' => NULL,'updated_at' => '2023-06-29 06:44:51','deleted_at' => NULL,'manual_trigger' => 'Admin'),
                array('id' => '5','slug' => '30a5695c-ca16-4bdf-abf8-7dafe1578adc','step_type' => 'Seller','step_links' => '["15","12"]','title_en' => 'Payment confirmation pending','title_es' => 'Pendiente confirmacion cobro','description' => NULL,'cashed' => 'Yes','rate' => 'No','file_upload' => 'No','qr_code' => 'No','payment' => 'No','mipo_commission_payment' => 'No','is_active' => 'Yes','order_position' => '5','created_by' => NULL,'updated_by' => NULL,'created_at' => NULL,'updated_at' => '2023-06-17 06:15:13','deleted_at' => NULL,'manual_trigger' => 'None'),
                array('id' => '6','slug' => 'eaa4bc96-63d3-4be2-92b2-bafc3e6ce754','step_type' => 'Buyer','step_links' => NULL,'title_en' => 'Offer accepted, Digital Signature Needed','title_es' => 'Oferta aceptada, Requiere Firma Digital','description' => NULL,'cashed' => 'No','rate' => 'No','file_upload' => 'No','qr_code' => 'No','payment' => 'No','mipo_commission_payment' => 'No','is_active' => 'Yes','order_position' => '1','created_by' => NULL,'updated_by' => NULL,'created_at' => NULL,'updated_at' => '2023-05-12 05:02:29','deleted_at' => NULL,'manual_trigger' => 'None'),
                array('id' => '7','slug' => '7e81968e-3016-4d00-9a76-8a032e760bab','step_type' => 'Buyer','step_links' => NULL,'title_en' => 'Awaiting Seller Documents','title_es' => 'En espera de documentos del vendedor','description' => '','cashed' => 'No','rate' => 'No','file_upload' => 'No','qr_code' => 'No','payment' => 'No','mipo_commission_payment' => 'No','is_active' => 'Yes','order_position' => '2','created_by' => NULL,'updated_by' => NULL,'created_at' => NULL,'updated_at' => NULL,'deleted_at' => NULL,'manual_trigger' => 'None'),
                array('id' => '8','slug' => '991074c0-9d3e-49df-af34-f33f8dc8fbf5','step_type' => 'Buyer','step_links' => '["4"]','title_en' => 'Documents in Custody, Awaiting MIPO Verification','title_es' => 'Documentos en Custodia Aguardando Verificacion de MIPO','description' => NULL,'cashed' => 'No','rate' => 'No','file_upload' => 'No','qr_code' => 'No','payment' => 'No','mipo_commission_payment' => 'No','is_active' => 'Yes','order_position' => '3','created_by' => NULL,'updated_by' => NULL,'created_at' => NULL,'updated_at' => '2023-06-19 05:15:45','deleted_at' => NULL,'manual_trigger' => 'None'),
                array('id' => '9','slug' => 'ee279bd9-dbb5-44e7-aa4a-bd3bcc3e1166','step_type' => 'Buyer','step_links' => NULL,'title_en' => 'Documents Verified','title_es' => 'Documentos Verificados','description' => NULL,'cashed' => 'No','rate' => 'No','file_upload' => 'No','qr_code' => 'No','payment' => 'No','mipo_commission_payment' => 'No','is_active' => 'Yes','order_position' => '4','created_by' => NULL,'updated_by' => NULL,'created_at' => NULL,'updated_at' => '2023-06-15 06:04:38','deleted_at' => NULL,'manual_trigger' => 'None'),
                array('id' => '10','slug' => '5773320b-37ad-4dc0-a9f0-b2e5544ade8c','step_type' => 'Buyer','step_links' => '["11"]','title_en' => 'MIPO Commission Payment','title_es' => 'Pago de Comisión a MIPO','description' => NULL,'cashed' => 'No','rate' => 'No','file_upload' => 'No','qr_code' => 'No','payment' => 'No','mipo_commission_payment' => 'Yes','is_active' => 'Yes','order_position' => '5','created_by' => NULL,'updated_by' => NULL,'created_at' => NULL,'updated_at' => '2023-06-19 05:27:20','deleted_at' => NULL,'manual_trigger' => 'Admin'),
                array('id' => '11','slug' => '0ca0a3c2-832f-48d6-8c24-1b5a5974246d','step_type' => 'Buyer','step_links' => '["4","5"]','title_en' => 'Funds Transfer to Seller','title_es' => 'Transferencia/Pago a Vendedor','description' => NULL,'cashed' => 'No','rate' => 'No','file_upload' => 'Yes','qr_code' => 'No','payment' => 'Yes','mipo_commission_payment' => 'No','is_active' => 'Yes','order_position' => '6','created_by' => NULL,'updated_by' => NULL,'created_at' => NULL,'updated_at' => '2023-06-19 08:26:33','deleted_at' => NULL,'manual_trigger' => 'None'),
                array('id' => '12','slug' => '1c12f963-43e9-4196-adaf-930e2f110af8','step_type' => 'Buyer','step_links' => NULL,'title_en' => 'Documents availabel for pickup / request delivery','title_es' => 'Documentos disponibles para recogida/solicitud de entrega','description' => NULL,'cashed' => 'No','rate' => 'No','file_upload' => 'No','qr_code' => 'Yes','payment' => 'No','mipo_commission_payment' => 'No','is_active' => 'Yes','order_position' => '7','created_by' => NULL,'updated_by' => NULL,'created_at' => NULL,'updated_at' => '2023-05-15 22:47:24','deleted_at' => NULL,'manual_trigger' => 'None'),
                array('id' => '13','slug' => '845f18fe-41a7-4978-b2dc-79fa819f2bb2','step_type' => 'Buyer','step_links' => NULL,'title_en' => 'Documents delivered','title_es' => 'Documentos entregados','description' => '','cashed' => 'No','rate' => 'No','file_upload' => 'No','qr_code' => 'No','payment' => 'No','mipo_commission_payment' => 'No','is_active' => 'Yes','order_position' => '8','created_by' => NULL,'updated_by' => NULL,'created_at' => NULL,'updated_at' => NULL,'deleted_at' => NULL,'manual_trigger' => 'None'),
                array('id' => '14','slug' => '436a8008-b9f9-450e-aa63-aa2bd9218c39','step_type' => 'Buyer','step_links' => NULL,'title_en' => 'Documents Cashed / Issue detected','title_es' => 'Documentos Cobrados / Emisión detectada','description' => NULL,'cashed' => 'Yes','rate' => 'Yes','file_upload' => 'No','qr_code' => 'No','payment' => 'No','mipo_commission_payment' => 'No','is_active' => 'Yes','order_position' => '9','created_by' => NULL,'updated_by' => NULL,'created_at' => NULL,'updated_at' => '2023-05-12 04:33:27','deleted_at' => NULL,'manual_trigger' => 'None'),
                array('id' => '15','slug' => '913180e9-3ea2-4735-a9e7-3e460d2e3063','step_type' => 'Seller','step_links' => NULL,'title_en' => 'Collection received by seller','title_es' => 'Cobro recibido por vendedor','description' => 'Cobro recibido por
                vendedor','cashed' => 'No','rate' => 'No','file_upload' => 'No','qr_code' => 'No','payment' => 'No','mipo_commission_payment' => 'No','is_active' => 'Yes','order_position' => '6','created_by' => '1','updated_by' => '1','created_at' => '2023-06-17 06:13:39','updated_at' => '2023-06-17 06:14:02','deleted_at' => NULL,'manual_trigger' => 'None')
            );

        OperationProgress::insert($operation_progress);
    }

}
