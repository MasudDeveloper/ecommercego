<?php

namespace App\Http\Controllers;

use App\Models\{ThemeCustomize, ThemeCustomizeOrder};
use Illuminate\Http\Request;
use Qirolab\Theme\Theme;
use App\Models\Addon;
use App\Models\Plan;
use App\Models\Store;
use App\Models\Utility;

class ThemeCustomizeController extends Controller
{
    /**
     * Get allowed themes based on user's active subscription plan
     */
    private function getAllowedThemes($user = null)
    {
        $user = $user ?? auth()->user();
        if (!$user) {
            return [];
        }
        if ($user->type == 'super admin') {
            return Addon::where('status', '1')->pluck('theme_id')->toArray();
        }

        $plan = Plan::find($user->plan_id);
        $addons = Addon::where('status', '1')->pluck('theme_id')->toArray();

        // Strict theme filtering based on subscriber's plan
        if ($plan && !empty($plan->themes)) {
            $themes = array_map('trim', explode(',', $plan->themes));
        } elseif ($plan && (stripos($plan->name, 'landing') !== false || stripos($plan->name, 'ল্যান্ডিং') !== false || $plan->max_products == 1)) {
            $themes = ['single-product'];
        } else {
            $themes = ['stylique', 'greentic', 'techzonix', 'single-product'];
        }

        // Intersect with active addons to ensure valid installed themes
        $allowed = array_values(array_intersect($themes, $addons));
        return !empty($allowed) ? $allowed : ['single-product'];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (auth()->user() && auth()->user()->isAbleTo('Manage Themes')) {
            $themes = $this->getAllowedThemes();
            $addons = Addon::where('status', '1')->pluck('theme_id')->toArray();

            $currentStore = Store::find(getCurrentStore());
            $currentTheme = (APP_THEME() ?? null);

            // If the current store theme is not allowed in their plan, auto-switch to their allowed theme!
            if (!in_array($currentTheme, $themes) || empty($currentTheme)) {
                $currentTheme = $themes[0];
                if ($currentStore) {
                    $currentStore->update(['theme_id' => $currentTheme]);
                }
            }

            return view('theme_customize.index', compact('themes', 'currentTheme', 'addons'));
        } else {
           return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function themePages(Request $request, $theme)
    {
        if (auth()->user() && auth()->user()->isAbleTo('Manage Themes')) {
            $allowedThemes = $this->getAllowedThemes();
            if (!in_array($theme, $allowedThemes)) {
                return redirect()->route('theme.index')->with('error', __('This theme is not available in your current plan. Please upgrade your plan.'));
            }

            $path = base_path('themes/'.$theme.'/theme_json/pages.json');
            $page_json = json_decode(file_get_contents($path), true);

            return view('theme_customize.pages', compact('theme', 'page_json'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function themeCustomize(Request $request, $theme, $slug = null, $sub_slug = null)
    {
        if (auth()->user() && auth()->user()->isAbleTo('Manage Themes')) {
            $allowedThemes = $this->getAllowedThemes();
            if (!in_array($theme, $allowedThemes)) {
                return redirect()->route('theme.index')->with('error', __('This theme is not available in your current plan. Please upgrade your plan.'));
            }

            $pagePath = base_path('themes/'.$theme.'/theme_json/pages.json');
            $page_json = json_decode(file_get_contents($pagePath), true);

            $path = base_path('themes/'.$theme.'/theme_json/'.$slug.'.json');
            $theme_json = json_decode(file_get_contents($path), true);
            $settings = getThemeSetting(getCurrentStore(), $theme);
            if (empty($sub_slug)) {
                $sub_slug = $theme_json['sections'][0]['slug'] ?? null;
            }

            return view('theme_customize.customize', compact('theme', 'slug', 'sub_slug', 'theme_json', 'page_json', 'settings'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function themeCustomizeUpdate(Request $request, $theme)
    {
        // if (auth()->user() && auth()->user()->isAbleTo('Edit Theme')) {
            $data = $request->except('_token');
          
            foreach ($data as $key => $values) {
                if (strpos($key, '_repeater') !== false && is_array($values)) { // Check if key ends with _repeater and is an array
                    foreach ($values as $subKey => $value) {
                        if (! empty($value['image']) && gettype($value['image']) == 'object') {
                            $filenameWithExt = $value['image']->getClientOriginalName();
                            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                            $extension = $value['image']->getClientOriginalExtension();
                            $fileNameToStore = $filename.'_'.time().'.'.$extension;

                            
                            $upload = Utility::upload_file($value, 'image', $fileNameToStore, 'uploads/'.$theme);
                            if ($upload['flag'] == 1) {
                                $url = $upload['url'];
                                $data[$key][$subKey]['image'] = $url; // Assign the URL back to the corresponding key
                            } else {
                                return response()->json(['msg' => 'error', 'error' => $upload['msg']]);
                            }
                        }
                        if (! empty($value['background_image']) && gettype($value['background_image']) == 'object') {
                            $filenameWithExt = $value['background_image']->getClientOriginalName();
                            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                            $extension = $value['background_image']->getClientOriginalExtension();
                            $fileNameToStore = $filename.'_'.time().'.'.$extension;

                            
                            $upload = Utility::upload_file($value, 'background_image', $fileNameToStore, 'uploads/'.$theme);
                            if ($upload['flag'] == 1) {
                                $url = $upload['url'];
                                $data[$key][$subKey]['background_image'] = $url; // Assign the URL back to the corresponding key
                            } else {
                                return response()->json(['msg' => 'error', 'error' => $upload['msg']]);
                            }
                        }
                    }
                    $data[$key] = json_encode($data[$key]); // Convert the repeater array to JSON
                }

                if ((strpos($key, '_image') !== false || strpos($key, '_logo') !== false || strpos($key, '_favicon') !== false) && is_object($values)) { // Check if key ends with _repeater and is an array
                    $image_data = $key;
                    $filenameWithExt = $request->$image_data->getClientOriginalName();
                    $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                    $extension = $request->$image_data->getClientOriginalExtension();
                    $fileNameToStore = $filename.'_'.time().'.'.$extension;

                    $uplaod = Utility::upload_file($request, $image_data, $fileNameToStore, 'uploads/'.$theme);
                    if ($uplaod['flag'] == 1) {
                        $url = $uplaod['url'];
                        $data[$image_data] = $url;
                    } else {
                        return response()->json(['msg' => 'error', 'error' => $uplaod['msg']]);
                    }
                }
            }

            foreach ($data as $key => $value) {
                ThemeCustomize::updateOrCreate(['theme_id' => $theme, 'name' => $key, 'store_id' => getCurrentStore()], ['value' => $value]);
            }

            return redirect()->back()->with('success', __('Setting Saved Successfully.'));

        // } else {
        //     return redirect()->back()->with('error', __('Permission denied.'));
        // }
    }

    public function imageFileGet(Request $request)
    {
        if ($request->has('imgSrc')) {
            $imgSrc = $request->input('imgSrc');
            $imgUrl = get_file($imgSrc);

            return response()->json($imgUrl);
        } else {
            return response()->json(['error' => __('imgSrc parameter missing')], 400);
        }
    }

    public function changeOrder(Request $request, $theme, $slug = null, $sub_slug = null)
    {
        if (auth()->user() && auth()->user()->isAbleTo('Manage Themes')) {
            $allowedThemes = $this->getAllowedThemes();
            if (!in_array($theme, $allowedThemes)) {
                return redirect()->route('theme.index')->with('error', __('This theme is not available in your current plan. Please upgrade your plan.'));
            }

            $pagePath = base_path('themes/'.$theme.'/theme_json/pages.json');
            $page_json = json_decode(file_get_contents($pagePath), true);
            
            if (empty($sub_slug)) {
                $sub_slug = $theme_json['sections'][0]['slug'] ?? null;
            }

            $orders = null;
            $theme_order = ThemeCustomizeOrder::where('theme_id', $theme)->where('store_id', getCurrentStore())->where('page_slug', $slug)->first();
            if (! empty($theme_order)) {
                $orders = $theme_order->orders;
            }

            return view('theme_customize.order', compact('theme', 'slug', 'sub_slug', 'page_json', 'orders'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function updateOrder(Request $request, $theme)
    {      
        $allowedThemes = $this->getAllowedThemes();
        if (!in_array($theme, $allowedThemes)) {
            return redirect()->route('theme.index')->with('error', __('This theme is not available in your current plan. Please upgrade your plan.'));
        }

        ThemeCustomizeOrder::updateOrCreate(['theme_id' => $theme, 'page_slug' => $request->page_slug, 'store_id' => getCurrentStore()], ['orders' => $request->orders]);
        return redirect()->back()->with('success', __('Order change successfully.'));
    }

    public function makeActiveTheme(Request $request)
    {
        if (isset($request->theme_id)) {
            $allowedThemes = $this->getAllowedThemes();
            if (!in_array($request->theme_id, $allowedThemes)) {
                return redirect()->back()->with('error', __('This theme is not available in your current plan. Please upgrade your plan.'));
            }

            Store::where('id', getCurrentStore())->update(['theme_id' => $request->theme_id]);
        }
        return redirect()->back()->with('success', __('Theme active set successfully'));
    }
}
