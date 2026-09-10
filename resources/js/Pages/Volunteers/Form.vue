<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { useForm, Link } from "@inertiajs/vue3";
import { ArrowRight, Save } from "lucide-vue-next";

const sudanStates = [
    "الخرطوم",
    "الجزيرة",
    "النيل الأبيض",
    "النيل الأزرق",
    "سنار",
    "كسلا",
    "البحر الأحمر",
    "نهر النيل",
    "الشمالية",
    "شمال كردفان",
    "جنوب كردفان",
    "غرب كردفان",
    "شمال دارفور",
    "جنوب دارفور",
    "شرق دارفور",
    "غرب دارفور",
    "وسط دارفور",
    "القضارف",
];

const form = useForm({
    full_name: "",
    email: "",
    phone: "",
    whatsapp: "",
    residence_state: "",
    specialization: "",
    message_or_skills: "",
    status: "accepted",
    member_type: "volunteer",
});

const submit = () => {
    form.post("/admin/volunteers");
};
</script>

<template>
    <AuthenticatedLayout>
        <div class="mb-8 flex items-center gap-4">
            <Link
                href="/admin/volunteers"
                class="p-2 bg-white border border-slate-200 rounded-lg text-slate-600 hover:bg-slate-50 transition"
            >
                <ArrowRight class="w-5 h-5" />
            </Link>
            <div>
                <h2 class="text-2xl font-bold text-slate-800">
                    إضافة متطوع جديد بالنظام
                </h2>
                <p class="text-slate-500 text-sm mt-1">
                    تسجيل متطوع جديد مباشرة من الإدارة وتحديد مهاراته وتخصصه
                    الميداني.
                </p>
            </div>
        </div>

        <form
            @submit.prevent="submit"
            class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 md:p-8 space-y-6 max-w-2xl"
        >
            <div class="space-y-4">
                <div>
                    <label
                        class="block text-sm font-semibold text-slate-700 mb-2"
                        >الاسم الكامل للمتطوع *</label
                    >
                    <input
                        type="text"
                        v-model="form.full_name"
                        required
                        pattern="^[\p{L}\s']+$"
                        title="يرجى إدخال اسم صحيح يحتوي على حروف فقط."
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-slate-800 text-sm focus:outline-none"
                    />
                    <p
                        v-if="form.errors.full_name"
                        class="text-xs text-red-500 mt-1"
                    >
                        {{ form.errors.full_name }}
                    </p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label
                            class="block text-sm font-semibold text-slate-700 mb-2"
                            >البريد الإلكتروني
                        </label>
                        <input
                            type="email"
                            v-model="form.email"
                            class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-slate-800 text-sm focus:outline-none text-left"
                            dir="ltr"
                        />
                        <p
                            v-if="form.errors.email"
                            class="text-xs text-red-500 mt-1"
                        >
                            {{ form.errors.email }}
                        </p>
                    </div>
                    <div>
                        <label
                            class="block text-sm font-semibold text-slate-700 mb-2"
                            >رقم الهاتف *</label
                        >
                        <input
                            type="tel"
                            v-model="form.phone"
                            required
                            pattern="[0-9]{9,15}"
                            title="يرجى إدخال رقم هاتف صحيح يتكون من 9 إلى 15 رقماً بدون رموز."
                            class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-slate-800 text-sm focus:outline-none text-left"
                            dir="ltr"
                        />
                        <p
                            v-if="form.errors.phone"
                            class="text-xs text-red-400 mt-1"
                        >
                            {{ form.errors.phone }}
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label
                            class="block text-sm font-semibold text-slate-700 mb-2"
                            >رقم الواتساب *</label
                        >
                        <input
                            type="tel"
                            v-model="form.whatsapp"
                            required
                            pattern="[0-9]{9,15}"
                            title="يرجى إدخال رقم واتساب صحيح."
                            class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-slate-800 text-sm focus:outline-none text-left"
                            dir="ltr"
                        />
                        <p
                            v-if="form.errors.whatsapp"
                            class="text-xs text-red-500 mt-1"
                        >
                            {{ form.errors.whatsapp }}
                        </p>
                    </div>
                    <div>
                        <label
                            class="block text-sm font-semibold text-slate-700 mb-2"
                            >مكان الإقامة *</label
                        >
                        <select
                            v-model="form.residence_state"
                            required
                            class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-slate-800 text-sm focus:outline-none"
                        >
                            <option value="" disabled>
                                اختر الولاية أو خارج السودان
                            </option>
                            <optgroup label="داخل السودان">
                                <option
                                    v-for="state in sudanStates"
                                    :key="state"
                                    :value="state"
                                >
                                    {{ state }}
                                </option>
                            </optgroup>
                            <option value="خارج السودان">خارج السودان</option>
                        </select>
                        <p
                            v-if="form.errors.residence_state"
                            class="text-xs text-red-500 mt-1"
                        >
                            {{ form.errors.residence_state }}
                        </p>
                    </div>
                </div>

                <div>
                    <label
                        class="block text-sm font-semibold text-slate-700 mb-2"
                        >التخصص الوظيفي / المهارة</label
                    >
                    <input
                        type="text"
                        v-model="form.specialization"
                        pattern="^[\p{L}\s',\d\-]+$"
                        title="يرجى إدخال تخصص صحيح بشكل نصي."
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-slate-800 text-sm focus:outline-none"
                        placeholder="مثال: طبيب، مصمم جرافيك..."
                    />
                    <p
                        v-if="form.errors.specialization"
                        class="text-xs text-red-500 mt-1"
                    >
                        {{ form.errors.specialization }}
                    </p>
                </div>

                <div>
                    <label
                        class="block text-sm font-semibold text-slate-700 mb-2"
                        >حالة طلب الانضمام المباشر *</label
                    >
                    <select
                        v-model="form.status"
                        required
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-slate-800 text-sm focus:outline-none"
                    >
                        <option value="accepted">مقبول ومعتمد فوراً</option>
                        <option value="new">
                            جديد (قيد المراجعة والمطابقة)
                        </option>
                        <option value="rejected">مرفوض</option>
                    </select>
                </div>

                <div>
                    <label
                        class="block text-sm font-semibold text-slate-700 mb-2"
                        >تصنيف المسجل *</label
                    >
                    <select
                        v-model="form.member_type"
                        required
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-slate-800 text-sm focus:outline-none"
                    >
                        <option value="volunteer">متطوع</option>
                        <option value="member">عضو</option>
                    </select>
                    <p
                        v-if="form.errors.member_type"
                        class="text-xs text-red-500 mt-1"
                    >
                        {{ form.errors.member_type }}
                    </p>
                </div>

                <div>
                    <label
                        class="block text-sm font-semibold text-slate-700 mb-2"
                        >الخبرة والأعمال الإنسانية السابقة
                    </label>
                    <textarea
                        v-model="form.message_or_skills"
                        rows="4"
                        minlength="10"
                        title="يرجى إدخال وصف لا يقل عن 10 حروف عن الخبرة والأعمال السابقة."
                        placeholder="اذكر خبراتك السابقة، الأعمال التطوعية أو الإنسانية التي شاركت بها، والجهات التي عملت معها إن وجدت..."
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-slate-800 text-sm focus:outline-none"
                    ></textarea>
                    <p
                        v-if="form.errors.message_or_skills"
                        class="text-xs text-red-500 mt-1"
                    >
                        {{ form.errors.message_or_skills }}
                    </p>
                </div>
            </div>

            <div class="flex justify-end pt-4 border-t border-slate-100">
                <button
                    type="submit"
                    :disabled="form.processing"
                    class="flex items-center gap-2 px-6 py-2.5 bg-orange-500 hover:bg-orange-600 text-white font-bold text-sm rounded-lg shadow-sm transition"
                >
                    <Save class="w-4 h-4" />
                    <span>حفظ المتطوع</span>
                </button>
            </div>
        </form>
    </AuthenticatedLayout>
</template>
