<?php
namespace Sleefs\Tests\integration;

use Illuminate\Foundation\Testing\TestCase ;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Sleefs\Models\Shiphero\Vendor;
use Sleefs\Helpers\Google\SpreadSheets\ShipheroExtendedPoToGoogleSheetRecordConverter;


class ShipheroExtendedPoToGoogleSheetRecordConverterTest extends TestCase {

	use RefreshDatabase;
	private $rawExtendedPo, $rawPo;
	private static $vendor = '';

	public function setUp(): void
	{
		parent::setUp();
		$this->rawExtendedPo = json_decode('{"id":"UHVyY2hhc2VPcmRlcjoxNDkzNDgx","legacy_id":1493481,"po_number":"173892295001025491  Gloves","po_date":"2023-08-14 00:00:00","account_id":"QWNjb3VudDoxMTU3","vendor_id":"ND","created_at":"2023-05-04 15:45:08","fulfillment_status":"pending","po_note":"5\/8 Deposit $3,410.52\n7\/12 Balance $9,505.18","description":null,"subtotal":"11573.7","shipping_price":"1342.00","total_price":"12915.7","line_items":[{"node":{"id":"UHVyY2hhc2VPcmRlckxpbmVJdGVtOjIxODc3MzA5","price":"5.1300","po_id":"1493481","account_id":"QWNjb3VudDoxMTU3","warehouse_id":"V2FyZWhvdXNlOjE2ODQ=","vendor_id":"VmVuZG9yOjQxNjQ3MA==","po_number":"Gloves","sku":"SL-NEOORG-RG-M","barcode":"SL-NEOORG-RG-M","note":"","quantity":100,"quantity_received":100,"quantity_rejected":0,"product_name":"Hot Orange Sticky Football Receiver Gloves M \/ Hot Orange","fulfillment_status":"pending","vendor":null}},{"node":{"id":"UHVyY2hhc2VPcmRlckxpbmVJdGVtOjIxODc3MzE0","price":"4.8500","po_id":"1493481","account_id":"QWNjb3VudDoxMTU3","warehouse_id":"V2FyZWhvdXNlOjE2ODQ=","vendor_id":"VmVuZG9yOjQxNjQ3MA==","po_number":"Gloves","sku":"SL-WHT-RG-L","barcode":"SL-WHT-RG-L","note":"","quantity":500,"quantity_received":0,"quantity_rejected":0,"product_name":"Basic White Sticky Football Receiver Gloves L \/ White","fulfillment_status":"pending","vendor":null}},{"node":{"id":"UHVyY2hhc2VPcmRlckxpbmVJdGVtOjIxODc3MzE2","price":"5.1300","po_id":"1493481","account_id":"QWNjb3VudDoxMTU3","warehouse_id":"V2FyZWhvdXNlOjE2ODQ=","vendor_id":"VmVuZG9yOjQxNjQ3MA==","po_number":"Gloves","sku":"SL-NEOPNK-RG-L","barcode":"SL-NEOPNK-RG-L","note":"","quantity":150,"quantity_received":150,"quantity_rejected":0,"product_name":"Neon Pink Sticky Football Receiver Gloves L \/ Pink","fulfillment_status":"pending","vendor":null}},{"node":{"id":"UHVyY2hhc2VPcmRlckxpbmVJdGVtOjIxODc3MzEy","price":"4.7600","po_id":"1493481","account_id":"QWNjb3VudDoxMTU3","warehouse_id":"V2FyZWhvdXNlOjE2ODQ=","vendor_id":"VmVuZG9yOjQxNjQ3MA==","po_number":"Gloves","sku":"SL-BLK-RG-L","barcode":"SL-BLK-RG-L","note":"","quantity":500,"quantity_received":0,"quantity_rejected":0,"product_name":"Basic Black Sticky Football Receiver Gloves L \/ Black","fulfillment_status":"pending","vendor":null}},{"node":{"id":"UHVyY2hhc2VPcmRlckxpbmVJdGVtOjIxODc3MzEx","price":"4.8500","po_id":"1493481","account_id":"QWNjb3VudDoxMTU3","warehouse_id":"V2FyZWhvdXNlOjE2ODQ=","vendor_id":"VmVuZG9yOjQxNjQ3MA==","po_number":"Gloves","sku":"SL-WHT-RG-M","barcode":"SL-WHT-RG-M","note":"","quantity":500,"quantity_received":0,"quantity_rejected":0,"product_name":"Basic White Sticky Football Receiver Gloves M \/ White","fulfillment_status":"pending","vendor":null}},{"node":{"id":"UHVyY2hhc2VPcmRlckxpbmVJdGVtOjIxODc3MzEw","price":"4.7600","po_id":"1493481","account_id":"QWNjb3VudDoxMTU3","warehouse_id":"V2FyZWhvdXNlOjE2ODQ=","vendor_id":"VmVuZG9yOjQxNjQ3MA==","po_number":"Gloves","sku":"SL-YELLEM-RG-XL","barcode":"SL-YELLEM-RG-XL","note":"","quantity":100,"quantity_received":100,"quantity_rejected":0,"product_name":"Hue Lemon Yellow Sticky Football Receiver Gloves XL \/ Lemon Yellow","fulfillment_status":"pending","vendor":null}},{"node":{"id":"UHVyY2hhc2VPcmRlckxpbmVJdGVtOjIxODc3MzEz","price":"4.7600","po_id":"1493481","account_id":"QWNjb3VudDoxMTU3","warehouse_id":"V2FyZWhvdXNlOjE2ODQ=","vendor_id":"VmVuZG9yOjQxNjQ3MA==","po_number":"Gloves","sku":"SL-BLK-RG-M","barcode":"SL-BLK-RG-M","note":"","quantity":500,"quantity_received":0,"quantity_rejected":0,"product_name":"Basic Black Sticky Football Receiver Gloves M \/ Black","fulfillment_status":"pending","vendor":null}},{"node":{"id":"UHVyY2hhc2VPcmRlckxpbmVJdGVtOjIxODc3MzE1","price":"5.1300","po_id":"1493481","account_id":"QWNjb3VudDoxMTU3","warehouse_id":"V2FyZWhvdXNlOjE2ODQ=","vendor_id":"VmVuZG9yOjQxNjQ3MA==","po_number":"Gloves","sku":"SL-NEOPNK-RG-XXL","barcode":"SL-NEOPNK-RG-XXL","note":"","quantity":40,"quantity_received":40,"quantity_rejected":0,"product_name":"Neon Pink Sticky Football Receiver Gloves XXL \/ Pink","fulfillment_status":"pending","vendor":null}}],"vendor_name":"ND"}');


		$this->rawPo = json_decode('{"test":"0","purchase_order":{"id":1493481,"po_number":"173892295001025491  Gloves","po_id":2833,"po_uuid":"UHVyY2hhc2VPcmRlcjoxNDkzNDgx","account_id":1157,"line_items":[{"id":"01e401df8f48345cbc46","quantity":100,"quantity_received":100,"sku":"SL-NEOORG-RG-M","vendor_id":416470,"vendor_uuid":"VmVuZG9yOjQxNjQ3MA==","vendor_account_number":"","vendor_sku":""},{"id":"0a59bdc5561e83941a51","quantity":500,"quantity_received":0,"sku":"SL-WHT-RG-L","vendor_id":416470,"vendor_uuid":"VmVuZG9yOjQxNjQ3MA==","vendor_account_number":"","vendor_sku":""},{"id":"130ba79e6b59d270e5fb","quantity":150,"quantity_received":150,"sku":"SL-NEOPNK-RG-L","vendor_id":416470,"vendor_uuid":"VmVuZG9yOjQxNjQ3MA==","vendor_account_number":"","vendor_sku":""},{"id":"5b07a673a5361a2cea4f","quantity":500,"quantity_received":0,"sku":"SL-BLK-RG-L","vendor_id":416470,"vendor_uuid":"VmVuZG9yOjQxNjQ3MA==","vendor_account_number":"","vendor_sku":""},{"id":"6ea7667b69b71358d3ae","quantity":500,"quantity_received":0,"sku":"SL-WHT-RG-M","vendor_id":416470,"vendor_uuid":"VmVuZG9yOjQxNjQ3MA==","vendor_account_number":"","vendor_sku":""},{"id":"73a9bace762964218d43","quantity":100,"quantity_received":100,"sku":"SL-YELLEM-RG-XL","vendor_id":416470,"vendor_uuid":"VmVuZG9yOjQxNjQ3MA==","vendor_account_number":"","vendor_sku":""},{"id":"8ff37f14a57fbf2179d9","quantity":500,"quantity_received":0,"sku":"SL-BLK-RG-M","vendor_id":416470,"vendor_uuid":"VmVuZG9yOjQxNjQ3MA==","vendor_account_number":"","vendor_sku":""},{"id":"ad67e4d5eef0434f289d","quantity":40,"quantity_received":40,"sku":"SL-NEOPNK-RG-XXL","vendor_id":416470,"vendor_uuid":"VmVuZG9yOjQxNjQ3MA==","vendor_account_number":"","vendor_sku":""}],"warehouse_id":1684,"status":"pending","webhook_type":"PO Update"}}');

		if (self::$vendor == '')
		{
			self::$vendor = new Vendor();
			self::$vendor->idsp = 'VmVuZG9yOjQxNjQ3MA==';
			self::$vendor->name = 'FUJIAN HUAFEI LEATHER PRODUCTS';
			self::$vendor->legacy_idsp = '416470';
			self::$vendor->email = 'sales5@wonny.cn';
			self::$vendor->created_at = '2023-07-11 21:49:11';
			self::$vendor->created_at = '2023-07-11 21:49:11';
			self::$vendor->save();	
		}

	}

	public function testConvertRawPoToReadyForGSRecord ()
	{
		$poForGSheetConverter = new ShipheroExtendedPoToGoogleSheetRecordConverter();
		$this->rawExtendedPo->po_id = $this->rawPo->purchase_order->po_id;
		$poForGSheet = $poForGSheetConverter->convert($this->rawExtendedPo);
		$this->assertInstanceOf('stdClass',$poForGSheet);
		$this->assertEquals(8,$poForGSheet->qty_of_skus);
		$this->assertEquals('FUJIAN HUAFEI LEATHER PRODUCTS',$poForGSheet->vendor);
		$this->assertEquals('pending',$poForGSheet->status);
		$this->assertEquals(11573.7,$poForGSheet->product_cost);
	}

	/* Preparing the Test */
	public function createApplication(){
        $app = require __DIR__.'/../../../../bootstrap/app.php';
        $app->make(Kernel::class)->bootstrap();
        return $app;
    }
}