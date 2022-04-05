<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactFormRequest;
use App\Http\Requests\CreateUserRequest;
use App\Mail\SendContactForm;
use App\Models\Advertising;
use App\Models\Blog;
use App\Models\Category;
use App\Models\City;
use App\Models\Hospital;
use App\Models\Rating;
use App\Models\Tag;
use App\Models\User;
use App\Traits\LogTrait;
use Artesaos\SEOTools\Traits\SEOTools as SEOToolsTrait;
use Auth;
use Carbon\Carbon;
use DB;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\App;
use Mail;
use SEOMeta;
use Session;
use Swift_Events_TransportExceptionEvent;
use URL;
use View;

class WebController extends Controller
{
    use LogTrait;

    use SEOToolsTrait;

    public function __construct()
    {
        $cities = City::select('city.id', 'city.city', 'city.image', 'city.copy', DB::raw('round(avg(rating.star_number)) as rating'))
            ->join('hospital', 'hospital.city_id', '=', 'city.id', 'left outer')
            ->join('rating', 'rating.id', '=', 'hospital.rating_id', 'left outer')
            ->where('city.status', 1)
            ->orderBy('city.city', 'asc')
            ->groupBy('city.id')
            ->with('hospitals')
            ->get();

        $ratings = Rating::orderBy('star_number', 'asc')
            ->with(['hospitals'])
            ->get();

        $blogs = Blog::where('status', 1)
            ->with([
                'topics',
                'tags',
                'categories',
            ])
            ->orderBy('date_to_publish', 'desc')
            ->limit(3)
            ->get();

        View::share('cities', $cities);
        View::share('ratings', $ratings);
        View::share('blogs', $blogs);
    }

    public function paypal()
    {
        return view('paypal');
    }

    public function getIndex()
    {
        $ads = Advertising::where('status', 1)
            ->orderBy('published_at', 'desc')
            ->get();

        $this->seo()->setTitle('Como Dar a Luz En Estados Unidos | Turismo de Maternidad');
        $this->seo()->setDescription('Te ayudamos a tener a tu bebé en Estados Unidos. Conoce cómo dar a luz de forma legal, segura y con los mejores médicos a nivel internacional.');

        $this->seo()->opengraph()->setTitle('Como Dar a Luz En Estados Unidos | Turismo de Maternidad');
        $this->seo()->opengraph()->setDescription('Te ayudamos a tener a tu bebé en Estados Unidos. Conoce cómo dar a luz de forma legal, segura y con los mejores médicos a nivel internacional.');
        $this->seo()->opengraph()->setUrl(route('web.index'));
        $this->seo()->opengraph()->setType('website');
        $this->seo()->opengraph()->addImage(asset('img/logos/BPF.jpg'));
        SEOMeta::setKeywords(['tener a mi bebé en Estados Unidos', 'parto en Estados Unidos', 'turismo de maternidad']);

        return view('web.welcome', ['ads' => $ads]);
    }

    public function getAboutUs()
    {
        $this->seo()->setTitle('Descubre Cómo Tener Más Pacientes | Ginecólogos');
        $this->seo()->setDescription('Si eres ginecólogo, comienza a ganar por referir o a tener más pacientes, a través de nuestra red médica a nivel internacional. ¡Obtén más información ahora!');

        $this->seo()->opengraph()->setTitle('Nosotros');
        $this->seo()->opengraph()->setUrl(route('web.getAboutUs'));
        $this->seo()->opengraph()->addImage(asset('img/logos/BPF.jpg'));
        SEOMeta::setKeywords(['turismo maternidad', 'parto en Estados Unidos', 'parto en USA', 'embarazo', 'ginecologos en USA']);

        return view('web.about-us');
    }

    public function getHowToWin()
    {
        $this->seo()->setTitle('BabyPassport | Como ganar con nosotros');
        $this->seo()->setDescription('Conoce nuestra estrategia integral para la atracción de pacientes.');

        $this->seo()->opengraph()->setTitle('Como ganar con nosotros');
        $this->seo()->opengraph()->setUrl(route('web.getHowToWin'));
        $this->seo()->opengraph()->addImage(asset('img/logos/BPF.jpg'));
        SEOMeta::setKeywords(['turismo maternidad', 'parto en Estados Unidos', 'parto en USA', 'embarazo', 'ginecologos en USA']);

        return view('web.how-to-win');
    }

    public function getGuiapartoenusa()
    {
        return view('subdomains.guiababyusa');
    }

    public function getSitemap()
    {

        // create new sitemap object
        $sitemap = App::make('sitemap');

        // set cache key (string), duration in minutes (Carbon|Datetime|int), turn on/off (boolean)
        // by default cache is disabled
        $sitemap->setCache('laravel.sitemap', 60);

        // check if there is cached sitemap and build new only if is not
        if (!$sitemap->isCached()) {
            $sitemap->add(URL::to('/'), Carbon::now()->toDateTimeString(), '1.0', 'daily');
            $sitemap->add(route('web.getAtentionCenter'), Carbon::now()->toDateTimeString(), '2.0', 'monthly');
            $sitemap->add(route('web.getBlog'), Carbon::now()->toDateTimeString(), '2.0', 'yearly');
            $sitemap->add(route('web.getBlog'), Carbon::now()->toDateTimeString(), '2.0', 'daily');
            $sitemap->add(route('web.getFaqs'), Carbon::now()->toDateTimeString(), '2.0', 'monthly');
            $sitemap->add(route('web.getTerms'), Carbon::now()->toDateTimeString(), '2.0', 'yearly');
            $sitemap->add(route('web.getPolicies'), Carbon::now()->toDateTimeString(), '2.0', 'yearly');
            $sitemap->add(route('web.getAboutUs'), Carbon::now()->toDateTimeString(), '2.0', 'monthly');

            //Adding Blog Categories
            $categories = Category::where('status', 1)->get();
            foreach ($categories as $category) {
                $sitemap->add(route('web.getBlogByCategory', [rawurlencode($category->category)]), Carbon::now()->toDateTimeString(), '2.0', 'monthly');
            }

            //Adding Blog Tags
            $tags = Tag::where('status', 1)->get();
            foreach ($tags as $tag) {
                $sitemap->add(route('web.getBlogByTag', [rawurlencode($tag->tag)]), Carbon::now()->toDateTimeString(), '2.0', 'monthly');
            }

            //Adding hospitals profile
            $hospitals = Hospital::orderby('name')->get();
            foreach ($hospitals as $hospital) {
                $sitemap->add(route('web.getHospital', [rawurlencode($hospital->name)]), Carbon::now()->toDateTimeString(), '2.0', 'monthly');
            }

            //Adding All Blogs
            $blogs = Blog::where('status', 1)->get();
            foreach ($blogs as $blog) {
                $sitemap->add(route('web.getDetailBlog', [rawurlencode($blog->title)]), $blog->updated_at, '2.0', 'monthly');
            }
        }

        // show your sitemap (options: 'xml' (default), 'html', 'txt', 'ror-rss', 'ror-rdf')
        return $sitemap->render('xml');
    }

    public function getFaqs()
    {
        $this->seo()->setTitle('BabyPassport | Resuelve tus dudas sobre cómo tener a tu bebé en Estados Unidos');
        $this->seo()->setDescription('¿Quieres tener a tu bebé en Estados Unidos?, pero tienes preocupaciones como: ¿Es legal?,¿Qué documentación necesito?, resuelve estas dudas con nosotros.');

        $this->seo()->opengraph()->setTitle('Resuelve tus dudas sobre cómo tener a tu bebé en Estados Unidos');
        $this->seo()->opengraph()->setUrl(route('web.index'));
        $this->seo()->opengraph()->addImage(asset('img/logos/BPF.jpg'));
        SEOMeta::setKeywords(['turismo maternidad', 'parto en Estados Unidos', 'parto en USA', 'embarazo']);

        return view('web.faqs');
    }

    public function getMomSearch()
    {
        $this->seo()->setTitle('BabyPassport | Las mejores ciudades para tener a tu bebé en Estados Unidos');
        $this->seo()->setDescription('Conoce las ciudades que cuentan con los mejores doctores bilingües especializados en partos de mamás latinoamericanas,');

        $this->seo()->opengraph()->setTitle('Las mejores ciudades para tener a tu bebé en Estados Unidos');
        $this->seo()->opengraph()->setUrl(route('web.index'));
        $this->seo()->opengraph()->addImage(asset('img/logos/BPF.jpg'));
        SEOMeta::setKeywords(['turismo maternidad', 'parto en Estados Unidos', 'parto en USA', 'embarazo', 'ginecologos en USA']);

        return view('web.locations');
    }

    public function cityPage($encodedCity)
    {
        $city = City::where('city', rawurldecode($encodedCity))
            ->with('hospitals')
            ->first();

        if (empty($city)) {
            abort(404, 'No se encontró la ciudad');
        }

        $productsPriceRanges = $city->products()->select('product_id', DB::raw('min(hospital_product.price) as minPrice'), DB::raw('max(hospital_product.price) as maxPrice'))
            ->with('product.details')
            ->groupBy('product_id')
            ->get();

        $this->seo()->setTitle('BabyPassport | Clínicas para tener a tu bebé en ' . $city->city);
        $this->seo()->setDescription('Los mejores doctores bilingües en ' . $city->city . ' que te ayudarán a tener a tu bebé.');

        $this->seo()->opengraph()->setTitle('Clínicas para tener a tu bebé en ' . $city->city);
        $this->seo()->opengraph()->setUrl(route('web.index'));
        $this->seo()->opengraph()->addImage(asset('img/logos/BPF.jpg'));
        SEOMeta::setKeywords(['turismo maternidad', 'parto en Estados Unidos', 'parto en USA', 'embarazo', 'ginecologos en ' . $city->city]);

        return view('web.city', [
            'city' => $city,
            'productsPriceRanges' => $productsPriceRanges,
        ]);
    }

    public function getRegisterMom()
    {
        if (!Auth::guest()) {
            return redirect()->route('web.getMomProfile', [Auth::user()->id]);
        }

        $this->seo()->setTitle('BabyPassport | Regístrate con nosotros para tener a tu bebé en Estados Unidos 100% legal');
        $this->seo()->setDescription('Somos la única plataforma que te garantiza obtener la green card para tu bebé de forma 100% legal, nuestros asesores te acompañaran durante tu proceso.   ');

        $this->seo()->opengraph()->setTitle('');
        $this->seo()->opengraph()->setUrl(route('web.index'));
        $this->seo()->opengraph()->addImage(asset('img/logos/BPF.jpg'));
        SEOMeta::setKeywords(['turismo maternidad', 'parto en Estados Unidos', 'parto en USA', 'embarazo', 'ginecologos en USA']);

        return view('auth.register', ['userType' => 'mom']);
    }

    public function getContactForm()
    {
        return view('web.contact-form');
    }

    public function postContactForm(ContactFormRequest $request)
    {
        try {
            Mail::send(new SendContactForm($request->all()));

            Session::flash('success', 'Tu mensaje ha sido enviado correctamente, en unos momentos uno de nuestros asesores atenderá tus dudas.');

            return back();
        } catch (Swift_Events_TransportExceptionEvent $e) {
            Session::flash('error', 'Ocurrió un error al enviar tu mensaje, intenta de nuevo.');

            return back();
        }
    }

    public function getMom()
    {
        $this->seo()->setTitle('BabyPassport | Conoce el proceso para tener a tu bebé en Estados Unidos de forma legal');
        $this->seo()->setDescription('Al seguir nuestro proceso,obtendrás la green card para tu bebé de forma legal y rápida en 1 mes,
                                                tendrás acompañamiento de uno de nuestros asesores antes y durante tu proceso de embarazo y parto.');

        $this->seo()->opengraph()->setTitle('Conoce el proceso para tener a tu bebé en Estados Unidos de forma legal');
        $this->seo()->opengraph()->setUrl(route('web.index'));
        $this->seo()->opengraph()->addImage(asset('img/logos/BPF.jpg'));
        SEOMeta::setKeywords(['tener a mi bebé en Estados Unidos', 'parto en Estados Unidos', 'turismo de maternidad']);

        return view('web.im-mom');
    }

    public function getAtentionCenter()
    {
        $this->seo()->setTitle('BabyPassport | Centros de Atención');
        $this->seo()->setDescription('Pregunta por los paquetes de maternidad en Estados Unidos en nuestros centros de atención');

        $this->seo()->opengraph()->setTitle('Centros de Atención');
        $this->seo()->opengraph()->setUrl(route('web.doctor'));
        $this->seo()->opengraph()->addImage(asset('img/logos/BPF.jpg'));
        SEOMeta::setKeywords(['marketing digital médico', 'turismo médico', 'turismo de maternidad', 'parto en Estados Unidos', 'parto en USA', 'embarazo', 'ginecologos en USA']);

        return view('web.atention-center');
    }

    public function getAtentionCenterCity($city)
    {
        if ($city === 'CDMX') {
            $this->seo()->setTitle('Turismo de Partos | Ginecólogos');
            $this->seo()->setDescription('Lleva tu control de embarazo con ginecologos baby passport para ser referida y tener tu parto en Estados Unidos.');

            $this->seo()->opengraph()->setTitle('Turismo de Partos | Ginecólogos');
            $this->seo()->opengraph()->setUrl(route('web.doctor'));
            $this->seo()->opengraph()->addImage(asset('img/logos/BPF.jpg'));
            SEOMeta::setKeywords(['marketing digital médico', 'turismo médico', 'turismo de maternidad', 'parto en Estados Unidos', 'parto en USA', 'embarazo', 'ginecologos en USA']);

            return view('web.atention-center-CDMX');
        }

        $this->seo()->setTitle('Paquetes de Maternidad en Estados Unidos');
        $this->seo()->setDescription('Conoce nuestros paquetes de maternidad en Estados Unidos y viaja de forma legal y segura.');

        $this->seo()->opengraph()->setTitle('Paquetes de Maternidad en Estados Unidos');
        $this->seo()->opengraph()->setUrl(route('web.doctor'));
        $this->seo()->opengraph()->addImage(asset('img/logos/BPF.jpg'));
        SEOMeta::setKeywords(['marketing digital médico', 'turismo médico', 'turismo de maternidad', 'parto en Estados Unidos', 'parto en USA', 'embarazo', 'ginecologos en USA']);

        return view('web.atention-center-USA');
    }

    public function getSearchDoctores()
    {
        return view('web.doctores');
    }

    public function getDoctor()
    {
        $this->seo()->setTitle('BabyPassport | Red de Ginecólogos ');
        $this->seo()->setDescription('Descubre cómo atender a más y mejores pacientes en nuestra red de ginecólogos con la mejor metodología en el mercado digital');

        $this->seo()->opengraph()->setTitle('Red de ginecólogos Baby Passport');
        $this->seo()->opengraph()->setUrl(route('web.doctor'));
        $this->seo()->opengraph()->addImage(asset('img/logos/BPF.jpg'));
        SEOMeta::setKeywords(['marketing digital médico', 'turismo médico', 'turismo de maternidad', 'parto en Estados Unidos', 'parto en USA', 'embarazo', 'ginecologos en USA']);

        return view('web.doctor');
    }

    public function getRegisterDoctor()
    {
        return view('auth.register', ['userType' => 'doctor']);
    }

    public function getDoctorSubscription()
    {
        $this->seo()->setTitle('BabyPassport | Suscripción para atender más pacientes');
        $this->seo()->setDescription('Suscribete a nuestro contenido para atender a más y mejores pacientes');

        $this->seo()->opengraph()->setTitle('Suscripción para atender más pacientes');
        $this->seo()->opengraph()->setUrl(route('web.doctorSubscription'));
        $this->seo()->opengraph()->addImage(asset('img/logos/BPF.jpg'));
        SEOMeta::setKeywords(['turismo maternidad', 'parto en Estados Unidos', 'parto en USA', 'embarazo', 'ginecologos en USA']);

        return view('web.doctor-subscription');
    }

    public function getBooking()
    {
        $this->seo()->setTitle('BabyPassport | Contratación');
        $this->seo()->setDescription('Contrata tu paquete de maternidad para obtener la green card para tu bebé en Estados Unidos de forma 100% legal.');

        $this->seo()->opengraph()->setTitle('Contratación');
        $this->seo()->opengraph()->setUrl(route('web.getBooking'));
        $this->seo()->opengraph()->addImage(asset('img/logos/BPF.jpg'));
        SEOMeta::setKeywords(['turismo maternidad', 'parto en Estados Unidos', 'parto en USA', 'embarazo', 'ginecologos en USA']);

        return view('web.booking');
    }

    public function getTerms()
    {
        $this->seo()->setTitle('BabyPassport | Términos y Condiciones de Uso');
        $this->seo()->setDescription('Obtén más información sobre las Condiciones del servicio de Baby Passport, que rigen el uso de la plataforma y los productos...');

        $this->seo()->opengraph()->setTitle('Términos y Condiciones de Uso');
        $this->seo()->opengraph()->setUrl(route('web.getTerms'));
        $this->seo()->opengraph()->addImage(asset('img/logos/BPF.jpg'));
        SEOMeta::setKeywords(['turismo maternidad', 'parto en Estados Unidos', 'parto en USA', 'embarazo', 'ginecologos en USA']);

        return view('web.terms');
    }

    public function getPolicies()
    {
        $this->seo()->setTitle('BabyPassport | Políticas de Privacidad');
        $this->seo()->setDescription('Obtén más información sobre las politicas de privacidad sobre el uso de tus datos en nuestra plataforma...');

        $this->seo()->opengraph()->setTitle('Políticas de Privacidad');
        $this->seo()->opengraph()->setUrl(route('web.getPolicies'));
        $this->seo()->opengraph()->addImage(asset('img/logos/BPF.jpg'));
        SEOMeta::setKeywords(['turismo maternidad', 'parto en Estados Unidos', 'parto en USA', 'embarazo', 'ginecologos en USA']);

        return view('web.policies');
    }

    public function postDoctorSubscription(CreateUserRequest $request)
    {
        try {
            DB::beginTransaction();

            $user = User::create([
                'name' => $request['user']['name'],
                'email' => $request['user']['email'],
                'type' => 'main_doctor',
                'status' => 'active_subscription',
            ]);

            $user->address()->create($request['user_address']);

            DB::commit();

            return response()->json(['message' => 'Su suscripción ha sido registrada correctamente'], 200);
        } catch (QueryException $e) {
            DB::rollBack();

            $log = $this->saveLog($e->getMessage(), $e->getCode(), 'database');

            return response()->json([
                'message' => 'Hubo un error al guardar su suscripción, consulte al administrador del sistema',
                'log_uuid' => $log->uuid,
            ], 500);
        }
    }
}
