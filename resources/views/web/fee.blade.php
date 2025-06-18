@extends('layouts.web')

@section('content')

<section style="margin-top: 30px;">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-xl-8">
                    <div class="title-block">
                        Home / Register / Fee
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- checkout start -->
    <main class="site-main woocommerce single single-product page-wrapper">
        <!--shop category start-->
        <section class="space-3">
            <div class="container">
                <div class="row">
                    <section id="primary" class="content-area col-lg-12">
                        <article id="post-8" class="post-8 page type-page status-publish hentry">
                            <div class="row">
                                <div class="col-lg-7 col-xl-7">
                                    <div class="col2-set" id="customer_details">
                                        <div class="col-12">
                                            <div class="woocommerce-billing-fields">
                                                <h3 id="order_review_heading">Fee Details</h3>
                                                <table class="shop_table woocommerce-checkout-review-order-table">
                                                    <thead>
                                                        <tr>
                                                            <th class="product-name">Fee Type</th>
                                                            <th class="product-name">Amount</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr class="cart_item">
                                                            <td class="product-name">
                                                                Conference Fee
                                                            </td>
                                                            <td class="product-total">
                                                                25
                                                            </td>
                                                        </tr>
                                                        <tr class="cart_item">
                                                            <td class="product-name">Tour Fee
                                                            </td>
                                                            <td class="product-total">
                                                                15
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                    <tfoot>
                                                        <tr class="order-total">
                                                            <th>Total</th>
                                                            <td><strong>40</strong></td>
                                                        </tr>
                                                    </tfoot>
                                                </table>

                                            </div>

                                        </div>

                                        <div class="col-12">
                                            <div class="woocommerce-shipping-fields">
                                            </div>
                                            <div class="woocommerce-additional-fields">
                                                <h5>Generate Control Number</h5>
                                                <form action="" method="post">
                                                    <div style="margin-top: 10px;">
                                                        <a style="background-color: #10497E; color: #fff;"
                                                            class="btn rounded">Generate</a> &nbsp; <input type="number"
                                                            disabled id="control-number">
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-5 col-xl-5">
                                    <div id="order_review" class="woocommerce-checkout-review-order">
                                        <h3 id="order_review_heading">Your Details</h3>
                                        <table class="shop_table woocommerce-checkout-review-order-table">
                                            <tbody>
                                                <tr class="cart_item">
                                                    <td class="">Full Name </td>
                                                    <td class=""> yasini selemani </td>
                                                </tr>
                                                <tr class="cart_item">
                                                    <td class="">Nationality </td>
                                                    <td class=""> Tanzanian </td>
                                                </tr>
                                                <tr class="cart_item">
                                                    <td class="">Email Address </td>
                                                    <td class=""> yasini@selemani </td>
                                                </tr>
                                                <tr class="cart_item">
                                                    <td class="">phone Number </td>
                                                    <td class=""> 0788475876 </td>
                                                </tr>
                                                <tr class="cart_item">
                                                    <td class="">Attendace</td>
                                                    <td class="">
                                                        <ul>
                                                            <li>workshop</li>
                                                            <li>conference</li>
                                                        </ul>
                                                    </td>
                                                </tr>
                                                <tr class="cart_item">
                                                    <td class=""><strong>Payment Status</strong></td>
                                                    <td class="">
                                                        <button class="btn btn-danger rounded" style="padding: 5px;">Not
                                                            Paid</button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>

                                    </div>
                                </div>

                            </div>

                </div>
            </div><!-- .entry-content -->

            </article><!-- #post-## -->

        </section>
        </div>
        </div>
        </section>
        <!--shop category end-->
    </main>

    <!-- Checkout form ENd -->

@endsection