@extends('layouts.app')
@section('title', ($org->name ?? '') . ' | ' . (app()->getLocale()==='en' ? 'Donate' : 'تبرع الآن'))

@section('content')

<section class="relative bg-rahma-gradient overflow-hidden">
    <div class="absolute inset-0 dotted-pattern"></div>
    <div class="max-w-5xl mx-auto px-4 py-16 text-center text-white relative">
        <h1 class="text-4xl lg:text-5xl font-black mb-4">{{ app()->getLocale()==='en' ? 'Be a Shade of Goodness' : 'كن ظلاً للخير' }}</h1>
        <p class="text-rahma-green-50/90 max-w-2xl mx-auto">{{ app()->getLocale()==='en' ? 'Your donation changes lives. Choose how you would like to give.' : 'تبرعك يصنع الفرق. اختر طريقة الدفع المناسبة لك.' }}</p>
    </div>
    <svg class="w-full text-rahma-cream" viewBox="0 0 1440 60" fill="currentColor"><path d="M0,32 C480,80 960,0 1440,32 L1440,60 L0,60 Z"/></svg>
</section>

@if(session('donation_success'))
<div class="max-w-3xl mx-auto mt-8 px-4">
    <div class="bg-rahma-green-50 border border-rahma-green-300 text-rahma-green-800 rounded-2xl p-5 flex items-center gap-3 font-semibold">
        <i data-lucide="check-circle" class="text-2xl text-rahma-green-600"></i>
        {{ app()->getLocale()==='en' ? 'Thank you! Your donation request has been received.' : 'شكراً لك! تم استلام طلب التبرع بنجاح.' }}
    </div>
</div>
@endif

<section class="max-w-6xl mx-auto px-4 py-16 grid lg:grid-cols-5 gap-10">

    {{-- Payment methods --}}
    <div class="lg:col-span-2 space-y-5">

        {{-- Section heading --}}
        <div>
            <h2 class="text-xl font-black text-rahma-green-800">
                {{ app()->getLocale() === 'en' ? 'Payment Methods' : 'وسائل الدفع' }}
            </h2>

            <p class="text-sm text-rahma-green-900/60 mt-1">
                {{ app()->getLocale() === 'en'
                    ? 'Choose any of the available payment methods below.'
                    : 'يمكنك استخدام أي من وسائل الدفع المتاحة أدناه.' }}
            </p>
        </div>

        {{-- Payment method cards --}}
        @foreach($paymentMethods as $method)

            <div
                class="group bg-white rounded-3xl p-5 sm:p-6
                    shadow-soft border border-rahma-green-100
                    border-s-4 border-s-rahma-gold-500
                    transition hover:-translate-y-0.5 hover:shadow-lg"
            >

                {{-- ================= METHOD HEADER ================= --}}
                <div class="flex items-center gap-3 sm:gap-4 mb-5">

                    {{-- Method Logo --}}
                    <div
                        class="w-14 h-14 sm:w-16 sm:h-16 shrink-0
                            rounded-2xl bg-rahma-gold-50
                            border border-rahma-gold-100
                            flex items-center justify-center
                            overflow-hidden"
                    >
                        @if($method->icon_url)

                            <img
                                src="{{ filter_var($method->icon_url, FILTER_VALIDATE_URL)
                                    ? $method->icon_url
                                    : asset($method->icon_url) }}"
                                alt="{{ $method->method_name }}"
                                class="w-full h-full object-contain p-2"
                                loading="lazy"
                            >

                        @else

                            {{-- Fallback icon --}}
                            <i
                                data-lucide="wallet"
                                class="w-7 h-7 text-rahma-gold-600"
                            ></i>

                        @endif
                    </div>

                    {{-- Method information --}}
                    <div class="min-w-0 flex-1">

                        {{-- Method name --}}
                        <h3
                            class="font-black text-base sm:text-lg
                                text-rahma-green-800"
                        >
                            {{ $method->method_name }}
                        </h3>

                        {{-- Account name --}}
                        @if($method->account_name)

                            <div class="mt-1.5 flex flex-wrap items-center gap-1.5 text-sm">

                                <span class="text-rahma-green-900/60">
                                    {{ app()->getLocale() === 'en'
                                        ? 'Account Name:'
                                        : 'اسم الحساب:' }}
                                </span>

                                <span class="font-bold text-rahma-green-800">
                                    {{ $method->account_name }}
                                </span>

                            </div>

                        @endif

                    </div>

                </div>


                {{-- ================= ACCOUNT NUMBER ================= --}}
                @if($method->account_number)

                    <div
                        class="rounded-2xl
                            bg-rahma-green-50
                            border border-rahma-green-100
                            p-4 mb-3"
                    >

                        <div
                            class="flex flex-col
                                sm:flex-row
                                sm:items-center
                                sm:justify-between
                                gap-3"
                        >

                            {{-- Account number --}}
                            <div class="min-w-0">

                                <span
                                    class="block text-xs
                                        text-rahma-green-900/60 mb-1"
                                >
                                    {{ app()->getLocale() === 'en'
                                        ? 'Account / Number'
                                        : 'رقم الحساب' }}
                                </span>

                                <span
                                    class="block font-black
                                        text-lg sm:text-xl
                                        tracking-wide
                                        text-rahma-green-800
                                        break-all"
                                    dir="ltr"
                                >
                                    {{ $method->account_number }}
                                </span>

                            </div>


                            {{-- Copy button --}}
                            <button
                                type="button"
                                onclick="
                                    if (navigator.clipboard) {
                                        navigator.clipboard.writeText(
                                            @js($method->account_number)
                                        );
                                    }
                                "
                                class="self-start sm:self-auto
                                    inline-flex items-center
                                    justify-center gap-1.5
                                    rounded-xl
                                    bg-white
                                    border border-rahma-green-200
                                    px-3 py-2
                                    text-xs font-bold
                                    text-rahma-green-700
                                    hover:bg-rahma-green-50
                                    transition"
                            >

                                <i
                                    data-lucide="copy"
                                    class="w-3.5 h-3.5"
                                ></i>

                                {{ app()->getLocale() === 'en'
                                    ? 'Copy'
                                    : 'نسخ' }}

                            </button>

                        </div>

                    </div>

                @endif


                {{-- ================= PAYMENT INSTRUCTIONS ================= --}}
                @if($method->instructions)

                    <div
                        class="rounded-2xl
                            bg-slate-50
                            border border-slate-100
                            p-4"
                    >

                        <div
                            class="flex items-center gap-2 mb-2"
                        >

                            <i
                                data-lucide="info"
                                class="w-4 h-4
                                    text-rahma-gold-600"
                            ></i>

                            <span
                                class="text-xs font-bold
                                    text-rahma-green-800"
                            >
                                {{ app()->getLocale() === 'en'
                                    ? 'Payment Instructions'
                                    : 'تعليمات الدفع' }}
                            </span>

                        </div>

                        <p
                            class="text-sm
                                leading-7
                                text-rahma-green-900/70
                                whitespace-pre-line"
                        >
                            {{ $method->instructions }}
                        </p>

                    </div>

                @endif

            </div>

        @endforeach


        {{-- ================= EMPTY STATE ================= --}}
        @if($paymentMethods->isEmpty())

            <div
                class="bg-white
                    rounded-3xl
                    p-6
                    border border-dashed
                    border-rahma-green-200
                    text-center
                    text-sm
                    text-rahma-green-900/60"
            >
                {{ app()->getLocale() === 'en'
                    ? 'No payment methods are currently available.'
                    : 'لا توجد وسائل دفع متاحة حالياً.' }}
            </div>

        @endif

    </div>



    {{-- Donation form --}}
    <div class="lg:col-span-3">
        <div class="bg-white rounded-3xl p-8 shadow-soft">
            <h2 class="text-xl font-black text-rahma-green-800 mb-6">{{ app()->getLocale()==='en' ? 'Donation Details' : 'تفاصيل التبرع' }}</h2>
            <form method="POST" action="{{ route('donate.store') }}" class="space-y-5">
                @csrf
                <div class="grid sm:grid-cols-2 gap-5">
                    <div>
                        <label class="text-sm font-semibold text-rahma-green-800 mb-1 block">{{ app()->getLocale()==='en' ? 'Full Name' : 'الاسم الكامل' }}</label>
                        <input type="text" name="donor_name" class="w-full rounded-xl border border-rahma-green-200 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-rahma-green-400">
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-rahma-green-800 mb-1 block">{{ app()->getLocale()==='en' ? 'Phone' : 'رقم الهاتف' }}</label>
                        <input type="text" name="phone" class="w-full rounded-xl border border-rahma-green-200 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-rahma-green-400">
                    </div>
                </div>
                <div>
                    <label class="text-sm font-semibold text-rahma-green-800 mb-1 block">{{ app()->getLocale()==='en' ? 'Email' : 'البريد الإلكتروني' }}</label>
                    <input type="email" name="email" class="w-full rounded-xl border border-rahma-green-200 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-rahma-green-400">
                </div>

                <div class="grid sm:grid-cols-2 gap-5">
                    <div>
                        <label class="text-sm font-semibold text-rahma-green-800 mb-1 block">{{ app()->getLocale()==='en' ? 'Amount' : 'المبلغ' }}</label>
                        <input type="number" name="amount" required class="w-full rounded-xl border border-rahma-green-200 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-rahma-green-400">
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-rahma-green-800 mb-1 block">{{ app()->getLocale()==='en' ? 'Project (optional)' : 'المشروع (اختياري)' }}</label>
                        <select name="project_id" class="w-full rounded-xl border border-rahma-green-200 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-rahma-green-400">
                            <option value="">{{ app()->getLocale()==='en' ? 'General Fund' : 'صندوق عام' }}</option>
                            @foreach($projects as $p)
                                <option value="{{ $p->id }}">{{ $p->title_ar }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div>
                    <label class="text-sm font-semibold text-rahma-green-800 mb-2 block">{{ app()->getLocale()==='en' ? 'Payment Method' : 'طريقة الدفع' }}</label>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                        @foreach(['bankak'=>'بنكك','fawri'=>'فوري','mycash'=>'MyCash','bank_transfer'=>'تحويل بنكي'] as $key => $label)
                            <label class="cursor-pointer">
                                <input type="radio" name="payment_method" value="{{ $key }}" class="peer hidden" {{ $loop->first ? 'checked' : '' }}>
                                <div class="text-center text-sm font-bold py-3 rounded-xl border-2 border-rahma-green-100 peer-checked:border-rahma-gold-500 peer-checked:bg-rahma-gold-50 peer-checked:text-rahma-gold-700 text-rahma-green-700 transition">
                                    {{ $label }}
                                </div>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div>
                    <label class="text-sm font-semibold text-rahma-green-800 mb-2 block">{{ app()->getLocale()==='en' ? 'Donation Type' : 'نوع التبرع' }}</label>
                    <div class="grid grid-cols-2 gap-3">
                        <label class="cursor-pointer">
                            <input type="radio" name="donation_type" value="one_time" class="peer hidden" checked>
                            <div class="text-center text-sm font-bold py-3 rounded-xl border-2 border-rahma-green-100 peer-checked:border-rahma-green-500 peer-checked:bg-rahma-green-50 peer-checked:text-rahma-green-700 text-rahma-green-700 transition">{{ app()->getLocale()==='en' ? 'One-time' : 'مرة واحدة' }}</div>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" name="donation_type" value="recurring" class="peer hidden">
                            <div class="text-center text-sm font-bold py-3 rounded-xl border-2 border-rahma-green-100 peer-checked:border-rahma-green-500 peer-checked:bg-rahma-green-50 peer-checked:text-rahma-green-700 text-rahma-green-700 transition">{{ app()->getLocale()==='en' ? 'Recurring' : 'شهري متكرر' }}</div>
                        </label>
                    </div>
                </div>

                <div>
                    <label class="text-sm font-semibold text-rahma-green-800 mb-1 block">{{ app()->getLocale()==='en' ? 'Transaction Reference (optional)' : 'رقم العملية (اختياري)' }}</label>
                    <input type="text" name="transaction_reference" class="w-full rounded-xl border border-rahma-green-200 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-rahma-green-400">
                </div>

                <button type="submit" class="w-full bg-rahma-gradient text-white font-bold py-4 rounded-full shadow-soft hover:-translate-y-0.5 transition flex items-center justify-center gap-2">
                    <i data-lucide="heart-handshake"></i> {{ app()->getLocale()==='en' ? 'Submit Donation' : 'إرسال التبرع' }}
                </button>
            </form>
        </div>
    </div>
</section>

{{-- Volunteer section --}}
<section id="volunteer" class="bg-rahma-green-50/60 py-20">
    <div class="max-w-4xl mx-auto px-4">
        @if(session('volunteer_success'))
        <div class="bg-rahma-green-100 border border-rahma-green-300 text-rahma-green-800 rounded-2xl p-5 flex items-center gap-3 font-semibold mb-8">
            <i data-lucide="check-circle" class="text-2xl text-rahma-green-600"></i>
            {{ app()->getLocale()==='en' ? 'Thank you for volunteering! We will contact you soon.' : 'شكراً لتطوعك! سنتواصل معك قريباً.' }}
        </div>
        @endif
        <div class="text-center mb-10">
            <span class="text-rahma-gold-600 font-bold text-sm">{{ app()->getLocale()==='en' ? 'Give Your Time' : 'وقتك أيضاً عطاء' }}</span>
            <h2 class="text-3xl font-black text-rahma-green-800 mt-2">{{ app()->getLocale()==='en' ? 'Become a Volunteer' : 'تطوع معنا' }}</h2>
        </div>

        <div class="bg-white rounded-3xl p-8 shadow-soft">
            <form method="POST" action="{{ route('volunteer.store') }}" class="space-y-5">
                @csrf
                <div class="grid sm:grid-cols-2 gap-5">
                    <div>
                        <label class="text-sm font-semibold text-rahma-green-800 mb-1 block">{{ app()->getLocale()==='en' ? 'Full Name' : 'الاسم الكامل' }}</label>
                        <input type="text" name="full_name" required class="w-full rounded-xl border border-rahma-green-200 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-rahma-green-400">
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-rahma-green-800 mb-1 block">{{ app()->getLocale()==='en' ? 'Phone' : 'رقم الهاتف' }}</label>
                        <input type="text" name="phone" required class="w-full rounded-xl border border-rahma-green-200 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-rahma-green-400">
                    </div>
                </div>

                <div class="grid sm:grid-cols-2 gap-5">
                    <div>
                        <label class="text-sm font-semibold text-rahma-green-800 mb-1 block">{{ app()->getLocale()==='en' ? 'WhatsApp Number' : 'رقم الواتساب' }}</label>
                        <input type="text" name="whatsapp" required class="w-full rounded-xl border border-rahma-green-200 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-rahma-green-400" dir="ltr">
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-rahma-green-800 mb-1 block">{{ app()->getLocale()==='en' ? 'Residence' : 'مكان الإقامة' }}</label>
                        <select name="residence_state" required class="w-full rounded-xl border border-rahma-green-200 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-rahma-green-400">
                            <option value="" disabled selected>{{ app()->getLocale()==='en' ? 'Select state' : 'اختر الولاية' }}</option>
                            <optgroup label="{{ app()->getLocale()==='en' ? 'Inside Sudan' : 'داخل السودان' }}">
                                @foreach(['الخرطوم','الجزيرة','النيل الأبيض','النيل الأزرق','سنار','كسلا','البحر الأحمر','نهر النيل','الشمالية','شمال كردفان','جنوب كردفان','غرب كردفان','شمال دارفور','جنوب دارفور','شرق دارفور','غرب دارفور','وسط دارفور','القضارف'] as $state)
                                    <option value="{{ $state }}">{{ $state }}</option>
                                @endforeach
                            </optgroup>
                            <option value="خارج السودان">{{ app()->getLocale()==='en' ? 'Outside Sudan' : 'خارج السودان' }}</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="text-sm font-semibold text-rahma-green-800 mb-1 block">{{ app()->getLocale()==='en' ? 'Email' : 'البريد الإلكتروني' }}</label>
                    <input type="email" name="email" required class="w-full rounded-xl border border-rahma-green-200 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-rahma-green-400">
                </div>

                <div>
                    <label class="text-sm font-semibold text-rahma-green-800 mb-1 block">{{ app()->getLocale()==='en' ? 'Specialization' : 'التخصص' }}</label>
                    <input type="text" name="specialization" class="w-full rounded-xl border border-rahma-green-200 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-rahma-green-400">
                </div>

                <div>
                    <label class="text-sm font-semibold text-rahma-green-800 mb-1 block">{{ app()->getLocale()==='en' ? 'Your Experience & Past Humanitarian Work' : 'خبرتك وأعمالك الإنسانية السابقة' }}</label>
                    <textarea name="message_or_skills" rows="4" required
                        placeholder="{{ app()->getLocale()==='en' ? 'Describe your experience, previous volunteer or humanitarian work, and organizations you worked with...' : 'اذكر خبراتك، أعمالك التطوعية أو الإنسانية السابقة، والجهات التي عملت معها إن وجدت...' }}"
                        class="w-full rounded-xl border border-rahma-green-200 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-rahma-green-400"></textarea>
                </div>

                <button type="submit" class="w-full bg-rahma-gold-gradient text-white font-bold py-4 rounded-full shadow-soft hover:-translate-y-0.5 transition flex items-center justify-center gap-2">
                    <i data-lucide="send"></i> {{ app()->getLocale()==='en' ? 'Apply Now' : 'إرسال الطلب' }}
                </button>
            </form>
        </div>
    </div>
</section>

@endsection