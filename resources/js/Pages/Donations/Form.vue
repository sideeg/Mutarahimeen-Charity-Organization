<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { useForm, Link } from "@inertiajs/vue3";
import { ArrowRight, Save } from "lucide-vue-next";

defineProps({
    projects: Array,
});

const form = useForm({
    donor_name: "",
    email: "",
    phone: "",
    amount: "",
    payment_method: "bankak",
    donation_type: "one_time",
    project_id: "",
    transaction_reference: "",
    status: "confirmed", // Manual entries typically default to confirmed directly
    admin_notes: "",
});

const submit = () => {
    form.post("/admin/donations");
};
</script>

<template>
    <AuthenticatedLayout>
        <div class="mb-8 flex items-center gap-4">
            <Link
                href="/admin/donations"
                class="p-2 bg-white border border-slate-200 rounded-lg text-slate-600 hover:bg-slate-50 transition"
            >
                <ArrowRight class="w-5 h-5" />
            </Link>
            <div>
                <h2 class="text-2xl font-bold text-slate-800">
                    تسجيل تبرع يدوي بالنظام
                </h2>
                <p class="text-slate-500 text-sm mt-1">
                    إدراج التبرعات المستلمة خارجياً أو المعاملات اليدوية لتحديث
                    تقدم المشاريع.
                </p>
            </div>
        </div>

        <form
            @submit.prevent="submit"
            class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 md:p-8 space-y-6 max-w-2xl"
        >
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label
                        class="block text-sm font-semibold text-slate-700 mb-2"
                        >اسم المتبرع (اختياري)</label
                    >
                    <input
                        type="text"
                        v-model="form.donor_name"
                        pattern="^[\p{L}\s']+$"
                        title="يرجى إدخال اسم صحيح يحتوي على حروف فقط."
                        placeholder="اسم المتبرع الكامل أو فاعل خير"
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-slate-800 text-sm focus:outline-none"
                    />
                </div>
                <div>
                    <label
                        class="block text-sm font-semibold text-slate-700 mb-2"
                        >مبلغ التبرع (ج.س) *</label
                    >
                    <input
                        type="number"
                        v-model="form.amount"
                        required
                        min="1"
                        step="any"
                        placeholder="مثال: 5000"
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-slate-800 text-sm focus:outline-none text-left font-mono"
                    />
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label
                        class="block text-sm font-semibold text-slate-700 mb-2"
                        >البريد الإلكتروني</label
                    >
                    <input
                        type="email"
                        v-model="form.email"
                        placeholder="example@domain.com"
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-slate-800 text-sm focus:outline-none text-left"
                        dir="ltr"
                    />
                </div>
                <div>
                    <label
                        class="block text-sm font-semibold text-slate-700 mb-2"
                        >رقم الهاتف</label
                    >
                    <input
                        type="tel"
                        v-model="form.phone"
                        placeholder="09xxxxxxxx"
                        pattern="[0-9]{9,15}"
                        title="يرجى إدخال رقم هاتف صحيح يتكون من 9 إلى 15 رقماً بدون رموز."
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-slate-800 text-sm focus:outline-none text-left"
                        dir="ltr"
                    />
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label
                        class="block text-sm font-semibold text-slate-700 mb-2"
                        >طريقة الدفع المستلمة *</label
                    >
                    <select
                        v-model="form.payment_method"
                        required
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-slate-800 text-sm focus:outline-none"
                    >
                        <option value="bankak">بنكك (بنك الخرطوم)</option>
                        <option value="fawri">فوري (بنك فيصل)</option>
                        <option value="mycash">ماي كاش</option>
                        <option value="bank_transfer">
                            تحويل بنكي / نقدي مباشر
                        </option>
                    </select>
                </div>
                <div>
                    <label
                        class="block text-sm font-semibold text-slate-700 mb-2"
                        >نوع التكرار *</label
                    >
                    <select
                        v-model="form.donation_type"
                        required
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-slate-800 text-sm focus:outline-none"
                    >
                        <option value="one_time">مرة واحدة</option>
                        <option value="recurring">شهري مستمر</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label
                        class="block text-sm font-semibold text-slate-700 mb-2"
                        >تخصيص التبرع لمشروع</label
                    >
                    <select
                        v-model="form.project_id"
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-slate-800 text-sm focus:outline-none"
                    >
                        <option value="">سهم عام في المنظمة</option>
                        <option
                            v-for="proj in projects"
                            :key="proj.id"
                            :value="proj.id"
                        >
                            {{ proj.title_ar }}
                        </option>
                    </select>
                </div>
                <div>
                    <label
                        class="block text-sm font-semibold text-slate-700 mb-2"
                        >رقم الإيصال / الرقم المرجعي</label
                    >
                    <input
                        type="text"
                        v-model="form.transaction_reference"
                        placeholder="الرقم التعريفي للمعاملة البنكية"
                        pattern="[A-Za-z0-9\-\s]{5,50}"
                        title="يرجى إدخال رقم مرجعي صحيح يتكون من حروف وأرقام فقط."
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-slate-800 text-sm focus:outline-none font-mono text-left"
                        dir="ltr"
                    />
                </div>
            </div>

            <div class="grid grid-cols-1 gap-4 pt-4 border-t border-slate-100">
                <div>
                    <label
                        class="block text-sm font-semibold text-slate-700 mb-2"
                        >حالة التبرع المباشر *</label
                    >
                    <select
                        v-model="form.status"
                        required
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-slate-800 text-sm focus:outline-none"
                    >
                        <option value="confirmed">
                            مؤكد ومستلم في الحساب (تحديث فوري لنسب المشاريع)
                        </option>
                        <option value="pending">قيد الانتظار والمراجعة</option>
                        <option value="failed">مرفوض / معاملة خاطئة</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2"
                    >ملاحظات المشرف المالي</label
                >
                <textarea
                    v-model="form.admin_notes"
                    rows="3"
                    placeholder="دون هنا تفاصيل تأكيد المعاملة أو بيانات إضافية..."
                    class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-slate-800 text-sm focus:outline-none"
                ></textarea>
            </div>

            <div class="flex justify-end pt-4 border-t border-slate-100">
                <button
                    type="submit"
                    :disabled="form.processing"
                    class="flex items-center gap-2 px-6 py-2.5 bg-orange-500 hover:bg-orange-600 text-white font-bold text-sm rounded-lg shadow-sm transition"
                >
                    <Save class="w-4 h-4" />
                    <span>تسجيل وحفظ التبرع المالي</span>
                </button>
            </div>
        </form>
    </AuthenticatedLayout>
</template>
