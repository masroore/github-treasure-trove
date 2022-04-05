<?php

namespace App\Http\Controllers;

use App\admin_return_product;
use App\Adv;
use App\Blog;
use App\Brand;
use App\Category;
use App\Commission;
use App\coupan;
use App\DetailAds;
use App\Faq;
use App\Grandcategory;
use App\Hotdeal;
use App\Menu;
use App\Page;
use App\Product;
use App\Slider;
use App\Social;
use App\SpecialOffer;
use App\Store;
use App\Subcategory;
use App\Tax;
use App\TaxClass;
use App\Testimonial;
use App\unit;
use App\User;
use App\UserReview;
use App\Widgetsetting;

class QuickUpdateController extends Controller
{
    public function userUpdate($id)
    {
        $user = User::findorfail($id);
        if (1 == $user->status) {
            User::where('id', '=', $id)->update(['status' => 0]);

            return back()->with('added', __('User Status changed to deactive !'));
        }
        User::where('id', '=', $id)->update(['status' => 1]);

        return back()->with('added', __('User Status changed to Active !'));
    }

    public function storeUpdate($id)
    {
        $store = Store::findorfail($id);

        if (1 == $store->status) {
            Store::where('id', '=', $id)->update(['status' => '0']);

            return back()->with('added', __('Status changed to Deactive !'));
        }
        Store::where('id', '=', $id)->update(['status' => '1']);

        return back()->with('added', __('Status changed to active !'));
    }

    public function unitUpdate($id)
    {
        $unit = unit::findorfail($id);

        if (1 == $unit->status) {
            unit::where('id', '=', $id)->update(['status' => '0']);

            return back()->with('added', __('Status changed to Deactive !'));
        }
        unit::where('id', '=', $id)->update(['status' => '1']);

        return back()->with('added', __('Status changed to active !'));
    }

    public function menuUpdate($id)
    {
        $menu = Menu::findorfail($id);

        if (1 == $menu->status) {
            Menu::where('id', '=', $id)->update(['status' => '0']);

            return back()->with('added', __('Status changed to Deactive !'));
        }
        Menu::where('id', '=', $id)->update(['status' => '1']);

        return back()->with('added', __('Status changed to active !'));
    }

    public function productUpdate($id)
    {
        $product = Product::findorfail($id);

        if (1 == $product->status) {
            Product::where('id', '=', $id)->update(['status' => '0']);

            return back()->with('added', __('Status changed to Deactive !'));
        }
        Product::where('id', '=', $id)->update(['status' => '1']);

        return back()->with('added', __('Status changed to active !'));
    }

    public function catUpdate($id)
    {
        $cat = Category::findorfail($id);

        if (1 == $cat->status) {
            Category::where('id', '=', $id)->update(['status' => '0']);

            return back()->with('added', __('Status changed to Deactive !'));
        }
        Category::where('id', '=', $id)->update(['status' => '1']);

        return back()->with('added', __('Status changed to active !'));
    }

    public function subUpdate($id)
    {
        $sub = Subcategory::findorfail($id);

        if (1 == $sub->status) {
            Subcategory::where('id', '=', $id)->update(['status' => '0']);

            return back()->with('added', __('Status changed to Deactive !'));
        }
        Subcategory::where('id', '=', $id)->update(['status' => '1']);

        return back()->with('added', __('Status changed to active !'));
    }

    public function childUpdate($id)
    {
        $child = Grandcategory::findorfail($id);

        if (1 == $child->status) {
            Grandcategory::where('id', '=', $id)->update(['status' => '0']);

            return back()->with('added', __('Status changed to Deactive !'));
        }
        Grandcategory::where('id', '=', $id)->update(['status' => '1']);

        return back()->with('added', __('Status changed to active !'));
    }

    public function brandUpdate($id)
    {
        $brand = Brand::findorfail($id);

        if (1 == $brand->status) {
            Brand::where('id', '=', $id)->update(['status' => '0']);

            return back()->with('added', __('Status changed to Deactive !'));
        }
        Brand::where('id', '=', $id)->update(['status' => '1']);

        return back()->with('added', __('Status changed to active !'));
    }

    public function reviewUpdate($id)
    {
        $review = UserReview::findorfail($id);

        if (1 == $review->status) {
            UserReview::where('id', '=', $id)->update(['status' => '0']);

            return back()->with('added', __('Status changed to Deactive !'));
        }
        UserReview::where('id', '=', $id)->update(['status' => '1']);

        return back()->with('added', __('Status changed to active !'));
    }

    public function couponUpdate($id)
    {
        $coupon = coupan::findorfail($id);

        if (1 == $coupon->status) {
            coupan::where('id', '=', $id)->update(['status' => '0']);

            return back()->with('added', __('Status changed to Deactive !'));
        }
        coupan::where('id', '=', $id)->update(['status' => '1']);

        return back()->with('added', __('Status changed to active !'));
    }

    public function taxUpdate($id)
    {
        $tax = Tax::findorfail($id);

        if (1 == $tax->status) {
            Tax::where('id', '=', $id)->update(['status' => '0']);

            return back()->with('added', __('Status changed to Deactive !'));
        }
        Tax::where('id', '=', $id)->update(['status' => '1']);

        return back()->with('added', __('Status changed to active !'));
    }

    public function taxclassUpdate($id)
    {
        $taxclass = TaxClass::findorfail($id);

        if (1 == $taxclass->status) {
            TaxClass::where('id', '=', $id)->update(['status' => '0']);

            return back()->with('added', __('Status changed to Deactive !'));
        }
        TaxClass::where('id', '=', $id)->update(['status' => '1']);

        return back()->with('added', __('Status changed to active !'));
    }

    public function commissionUpdate($id)
    {
        $c = Commission::findorfail($id);

        if (1 == $c->status) {
            Commission::where('id', '=', $id)->update(['status' => '0']);

            return back()->with('added', __('Status changed to Deactive !'));
        }
        Commission::where('id', '=', $id)->update(['status' => '1']);

        return back()->with('added', __('Status changed to active !'));
    }

    public function banksUpdate($id)
    {
        $banks = admin_return_product::findorfail($id);

        if (1 == $banks->status) {
            admin_return_product::where('id', '=', $id)->update(['status' => '0']);

            return back()->with('added', __('Status changed to Deactive !'));
        }
        admin_return_product::where('id', '=', $id)->update(['status' => '1']);

        return back()->with('added', __('Status changed to active !'));
    }

    public function sliderUpdate($id)
    {
        $s = Slider::findorfail($id);

        if (1 == $s->status) {
            Slider::where('id', '=', $id)->update(['status' => '0']);

            return back()->with('added', __('Status changed to Deactive !'));
        }
        Slider::where('id', '=', $id)->update(['status' => '1']);

        return back()->with('added', __('Status changed to active !'));
    }

    public function faqUpdate($id)
    {
        $f = Faq::findorfail($id);

        if (1 == $f->status) {
            Faq::where('id', '=', $id)->update(['status' => '0']);

            return back()->with('added', __('Status changed to Deactive !'));
        }
        Faq::where('id', '=', $id)->update(['status' => '1']);

        return back()->with('added', __('Status changed to active !'));
    }

    public function blogUpdate($id)
    {
        $blog = Blog::findorfail($id);

        if (1 == $blog->status) {
            Blog::where('id', '=', $id)->update(['status' => '0']);

            return back()->with('added', __('Status changed to Deactive !'));
        }
        Blog::where('id', '=', $id)->update(['status' => '1']);

        return back()->with('added', __('Status changed to active !'));
    }

    public function pageUpdate($id)
    {
        $page = Page::findorfail($id);

        if (1 == $page->status) {
            Page::where('id', '=', $id)->update(['status' => '0']);

            return back()->with('added', __('Status changed to Deactive !'));
        }
        Page::where('id', '=', $id)->update(['status' => '1']);

        return back()->with('added', __('Status changed to active !'));
    }

    public function socialUpdate($id)
    {
        $social = Social::findorfail($id);

        if (1 == $social->status) {
            Social::where('id', '=', $id)->update(['status' => '0']);

            return back()->with('added', __('Status changed to Deactive !'));
        }
        Social::where('id', '=', $id)->update(['status' => '1']);

        return back()->with('added', __('Status changed to active !'));
    }

    public function hotdealUpdate($id)
    {
        $hd = Hotdeal::findorfail($id);

        if (1 == $hd->status) {
            Hotdeal::where('id', '=', $id)->update(['status' => '0']);

            return back()->with('added', __('Status changed to Deactive !'));
        }
        Hotdeal::where('id', '=', $id)->update(['status' => '1']);

        return back()->with('added', __('Status changed to active !'));
    }

    public function advUpdate($id)
    {
        $adv = Adv::findorfail($id);

        if (1 == $adv->status) {
            Adv::where('id', '=', $id)->update(['status' => 0]);

            return back()->with('added', __('Status changed to Deactive !'));
        }
        Adv::where('id', '=', $id)->update(['status' => 1]);

        return back()->with('added', __('Status changed to active !'));
    }

    public function clintUpdate($id)
    {
        $testi = Testimonial::findorfail($id);

        if (1 == $testi->status) {
            Testimonial::where('id', '=', $id)->update(['status' => '0']);

            return back()->with('added', __('Status changed to Deactive !'));
        }
        Testimonial::where('id', '=', $id)->update(['status' => '1']);

        return back()->with('added', __('Status changed to active !'));
    }

    public function widgethomeUpdate($id)
    {
        $wh = Widgetsetting::findorfail($id);

        if (1 == $wh->home) {
            Widgetsetting::where('id', '=', $id)->update(['home' => '0']);

            return back()->with('added', __('Status changed to Deactive !'));
        }
        Widgetsetting::where('id', '=', $id)->update(['home' => '1']);

        return back()->with('added', __('Status changed to active !'));
    }

    public function widgetshopUpdate($id)
    {
        $ws = Widgetsetting::findorfail($id);

        if (1 == $ws->shop) {
            Widgetsetting::where('id', '=', $id)->update(['shop' => '0']);

            return back()->with('added', __('Status changed to Deactive !'));
        }
        Widgetsetting::where('id', '=', $id)->update(['shop' => '1']);

        return back()->with('added', __('Status changed to active !'));
    }

    public function widgetpageUpdate($id)
    {
        $wp = Widgetsetting::findorfail($id);

        if (1 == $wp->page) {
            Widgetsetting::where('id', '=', $id)->update(['page' => '0']);

            return back()->with('added', __('Status changed to Deactive !'));
        }
        Widgetsetting::where('id', '=', $id)->update(['page' => '1']);

        return back()->with('added', __('Status changed to active !'));
    }

    public function catfeaUpdate($id)
    {
        $cat = Category::findorfail($id);

        if (1 == $cat->featured) {
            Category::where('id', '=', $id)->update(['featured' => '0']);

            return back()->with('added', __('Featured status set to NO !'));
        }
        Category::where('id', '=', $id)->update(['featured' => '1']);

        return back()->with('added', __('Featured status set to YES !'));
    }

    public function subfeaUpdate($id)
    {
        $sub = Subcategory::findorfail($id);

        if (1 == $sub->featured) {
            Subcategory::where('id', '=', $id)->update(['featured' => '0']);

            return back()->with('added', __('Featured status set to NO !'));
        }
        Subcategory::where('id', '=', $id)->update(['featured' => '1']);

        return back()->with('added', __('Featured status set to YES !'));
    }

    public function childfeaUpdate($id)
    {
        $child = Grandcategory::findorfail($id);

        if (1 == $child->featured) {
            Grandcategory::where('id', '=', $id)->update(['featured' => '0']);

            return back()->with('added', __('Featured status set to NO !'));
        }
        Grandcategory::where('id', '=', $id)->update(['featured' => '1']);

        return back()->with('added', __('Featured status set to YES !'));
    }

    public function productfeaUpdate($id)
    {
        $product = Product::findorfail($id);

        if (1 == $product->featured) {
            Product::where('id', '=', $id)->update(['featured' => '0']);

            return back()->with('added', __('Featured status set to NO !'));
        }
        Product::where('id', '=', $id)->update(['featured' => '1']);

        return back()->with('added', __('Featured status set to YES !'));
    }

    public function specialoffer($id)
    {
        $spo = SpecialOffer::findorfail($id);

        if (1 == $spo->status) {
            SpecialOffer::where('id', '=', $id)->update(['status' => '0']);

            return back()->with('added', __('Status changed to Deactive !'));
        }
        SpecialOffer::where('id', '=', $id)->update(['status' => '1']);

        return back()->with('added', __('Status changed to active !'));
    }

    public function acpstore($id)
    {
        abort_if(!auth()->user()->can('stores.accept.request'), 403, __('User does not have the right permissions.'));

        $store = Store::findorfail($id);

        if (1 == $store->apply_vender) {
            Store::where('id', '=', $id)->update(['status' => '0', 'apply_vender' => '0']);

            return back()->with('added', __('Store Request not accepted !'));
        }
        Store::where('id', '=', $id)->update(['status' => '1', 'apply_vender' => '1']);
        $store->user()->update([
            'role_id' => 'v',
        ]);

        return back()->with('added', __('Store Request accepted !'));
    }

    public function detail_button_Update($id)
    {
        $ad = DetailAds::findorfail($id);

        if (1 == $ad->status) {
            $ad->status = 0;
        } else {
            $ad->status = 1;
        }

        $ad->save();

        return back()->with('updated', __('Status has been changed !'));
    }
}
