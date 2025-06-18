@extends('layouts.web')

@section('content')

<!--====== Header End ======-->
 <section style="margin-top: 30px;">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-xl-8">
                    <div class="title-block">
                        Home / Programs / Workshop
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--shop category start-->
    <section class="woocommerce single page-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-xl-12">
                    <div class="woocommerce-cart">
                        <div class="woocommerce-notices-wrapper"></div>
                        <table class="shop_table shop_table_responsive cart woocommerce-cart-form__contents"
                            cellspacing="0">
                            <thead>
                                <tr>
                                    <th style="background-color: #10497E;">Time</th>
                                    <th style="background-color: #10497E;">Workshop</th>
                                    <th style="background-color: #10497E;">Venue</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr class="woocommerce-cart-form__cart-item cart_item">

                                    <td width="25%">
                                        <h6>MORNING SESSIONS</h6>
                                        <p class="time">08:00 - 13:00</p>
                                    </td>

                                    <td width="50%">
                                        <ul>
                                            <li>Emergency Skills Refresher Workshop for Nurses</li>
                                            <li>Emergency Skills Refresher Workshop for Nurses</li>
                                            <li>Emergency Skills Refresher Workshop for Nurses</li>
                                        </ul>
                                    </td>

                                    <td width="25%">
                                        <ul>
                                            <li>Mopane</li>
                                            <li>Mopane</li>
                                            <li>Mopane</li>
                                        </ul>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--shop category end-->
    @endsection