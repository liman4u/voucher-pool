<?php

namespace Test\Unit;

use App\Domain\Voucher\Helpers\RandomCodeGenerator;
use App\Domain\Voucher\Models\Voucher;

class VoucherPoolUnitTest extends \TestCase
{

    /**
     * Test for length of code
     */
    public function testVoucherCodeLength()
    {
        $generator = new RandomCodeGenerator();
        $code = strtoupper($generator->generate(8));

        $this->assertNotNull($code);
        $this->assertTrue(strlen($code) === 8);
    }

    /**
     * Test for validity of voucher code
     */
    public function testVoucherCodeValidity()
    {

        $voucher = factory(Voucher::class)->make();

        $this->assertTrue($voucher->isValid());

        $voucher->is_used = 1;

        $this->assertFalse($voucher->isValid());


    }




}
