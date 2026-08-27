<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { useForm, Link } from "@inertiajs/vue3";
import { ref } from "vue";
import { Check, X, Eye, Plus } from "lucide-vue-next";

defineProps({
    donations: Object,
});

const activeDonationDetail = ref(null);

const statusForm = useForm({
    status: "",
    admin_notes: "",
});

const openDetailModal = (donation) => {
    activeDonationDetail.value = donation;
    statusForm.status = donation.status;
    statusForm.admin_notes = donation.admin_notes || "";
};

const closeDetailModal = () => {
    activeDonationDetail.value = null;
};

const updateStatus = () => {
    statusForm.post(
        "/admin/donations/" + activeDonationDetail.value.id + "/status",
        {
            onSuccess: () => {
                closeDetailModal();
            },
        }
    );
};
</script>

<template>
    <AuthenticatedLayout>
        <!-- Header Actions Layout -->
        <div
            class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8 gap-4"
        >
            <div>
                <h2 class="text-2xl font-bold text-slate-800">
                    إدارة ومراجعة التبرعات الواردة
                </h2>
                <p class="text-slate-500 text-sm mt-1">
                    مطابقة المعاملات البنكية وتطبيق القيود المؤكدة وتعديل تقدم
                    المشاريع تلقائياً.
                </p>
            </div>
            <Link
                href="/admin/donations/create"
                class="flex items-center gap-2 px-4 py-2.5 bg-orange-500 text-white rounded-lg font-bold text-sm hover:bg-orange-600 transition shadow-sm cursor-pointer self-start"
            >
                <Plus class="w-4 h-4" />
                <span>تسجيل تبرع يدوي</span>
            </Link>
        </div>

        <div
            class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden"
        >
            <div class="overflow-x-auto">
                <table class="w-full text-right border-collapse">
                    <thead>
                        <tr
                            class="bg-slate-50 border-b border-slate-200 text-slate-600 text-xs font-bold uppercase tracking-wider"
                        >
                            <th class="py-4 px-6">المتبرع</th>
                            <th class="py-4 px-6">المبلغ</th>
                            <th class="py-4 px-6">طريقة الدفع</th>
                            <th class="py-4 px-6">رقم الإيصال/المرجع</th>
                            <th class="py-4 px-6">المشروع المستهدف</th>
                            <th class="py-4 px-6 text-center">الحالة</th>
                            <th class="py-4 px-6 text-center">مراجعة</th>
                        </tr>
                    </thead>
                    <tbody
                        class="divide-y divide-slate-150 text-sm text-slate-700"
                    >
                        <tr
                            v-for="donation in donations.data"
                            :key="donation.id"
                            class="hover:bg-slate-50/50"
                        >
                            <td class="py-4 px-6">
                                <span class="block font-bold text-slate-900">{{
                                    donation.donor_name || "فاعل خير"
                                }}</span>
                                <span
                                    class="block text-[10px] text-slate-400 mt-0.5"
                                    >{{ donation.phone || "بدون اتصال" }}</span
                                >
                            </td>
                            <td
                                class="py-4 px-6 font-mono font-bold text-slate-800"
                            >
                                {{
                                    new Intl.NumberFormat("ar-SD").format(
                                        donation.amount
                                    )
                                }}
                                ج.س
                            </td>
                            <td class="py-4 px-6 font-bold text-slate-600">
                                {{ donation.payment_method }}
                            </td>
                            <td class="py-4 px-6 font-mono text-slate-500">
                                {{
                                    donation.transaction_reference || "غير مدخل"
                                }}
                            </td>
                            <td class="py-4 px-6 font-bold text-slate-700">
                                {{
                                    donation.project?.title_ar ||
                                    "سهم عام بالمنظمة"
                                }}
                            </td>
                            <td class="py-4 px-6 text-center">
                                <span
                                    class="inline-block px-3 py-1 rounded-full text-[11px] font-bold"
                                    :class="{
                                        'bg-amber-100 text-amber-800':
                                            donation.status === 'pending',
                                        'bg-emerald-100 text-emerald-800':
                                            donation.status === 'confirmed',
                                        'bg-red-100 text-red-800':
                                            donation.status === 'failed',
                                    }"
                                >
                                    {{
                                        donation.status === "pending"
                                            ? "قيد الانتظار"
                                            : donation.status === "confirmed"
                                            ? "مؤكد ومستلم"
                                            : "مرفوض/فاشل"
                                    }}
                                </span>
                            </td>
                            <td class="py-4 px-6">
                                <div class="flex justify-center">
                                    <button
                                        @click="openDetailModal(donation)"
                                        class="p-2 text-slate-500 hover:text-orange-500 hover:bg-slate-100 rounded-lg transition cursor-pointer"
                                    >
                                        <Eye class="w-4 h-4" />
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr v-if="donations.data.length === 0">
                            <td
                                colspan="7"
                                class="py-8 text-center text-slate-400"
                            >
                                لا توجد سجلات تبرعات واردة لمراجعتها.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Paginated Navigation Links -->
        <div
            v-if="donations.links.length > 3"
            class="mt-6 flex justify-center gap-2"
        >
            <template v-for="(link, key) in donations.links" :key="key">
                <div
                    v-if="link.url === null"
                    class="px-4 py-2 border border-slate-200 text-slate-400 rounded-md text-xs"
                    v-html="link.label"
                ></div>
                <Link
                    v-else
                    :href="link.url"
                    class="px-4 py-2 border border-slate-200 text-slate-600 rounded-md text-xs hover:bg-slate-100 transition"
                    :class="{
                        'bg-orange-500 border-orange-500 text-white hover:bg-orange-600':
                            link.active,
                    }"
                    v-html="link.label"
                ></Link>
            </template>
        </div>

        <!-- Modal View for Auditing and Updates -->
        <div
            v-if="activeDonationDetail"
            class="fixed inset-0 z-50 flex items-center justify-center p-4"
        >
            <div
                class="fixed inset-0 bg-slate-900/60"
                @click="closeDetailModal"
            ></div>
            <div
                class="bg-white rounded-xl shadow-xl max-w-lg w-full relative z-10 overflow-hidden"
                dir="rtl"
            >
                <div class="p-6 border-b border-slate-100 bg-slate-50">
                    <h3 class="font-bold text-slate-800 text-lg">
                        تفاصيل وتدقيق سجل المعاملة المالية
                    </h3>
                </div>

                <form @submit.prevent="updateStatus" class="p-6 space-y-4">
                    <div
                        class="grid grid-cols-2 gap-4 text-xs border-b border-slate-100 pb-4"
                    >
                        <div>
                            <span class="text-slate-400 block mb-0.5"
                                >اسم المتبرع</span
                            >
                            <strong class="text-slate-700 text-sm">{{
                                activeDonationDetail.donor_name || "فاعل خير"
                            }}</strong>
                        </div>
                        <div>
                            <span class="text-slate-400 block mb-0.5"
                                >المبلغ المرصود</span
                            >
                            <strong class="text-emerald-600 text-sm font-mono"
                                >{{
                                    new Intl.NumberFormat("ar-SD").format(
                                        activeDonationDetail.amount
                                    )
                                }}
                                ج.س</strong
                            >
                        </div>
                        <div>
                            <span class="text-slate-400 block mb-0.5"
                                >وسيلة الإرسال</span
                            >
                            <strong class="text-slate-700 text-sm">{{
                                activeDonationDetail.payment_method
                            }}</strong>
                        </div>
                        <div>
                            <span class="text-slate-400 block mb-0.5"
                                >رقم المرجع المصرفي</span
                            >
                            <strong class="text-slate-700 text-sm font-mono">{{
                                activeDonationDetail.transaction_reference ||
                                "غير متوفر"
                            }}</strong>
                        </div>
                    </div>

                    <div>
                        <label
                            class="block text-xs font-semibold text-slate-700 mb-2"
                            >تحديث حالة السجل المالي</label
                        >
                        <select
                            v-model="statusForm.status"
                            class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-slate-800 text-sm focus:outline-none"
                        >
                            <option value="pending">
                                قيد الانتظار والمطابقة
                            </option>
                            <option value="confirmed">
                                مؤكد ومستلم في الحساب
                            </option>
                            <option value="failed">مرفوض/مسترجع/فاشل</option>
                        </select>
                    </div>

                    <div>
                        <label
                            class="block text-xs font-semibold text-slate-700 mb-2"
                            >ملاحظات المشرف المالي (داخلية)</label
                        >
                        <textarea
                            v-model="statusForm.admin_notes"
                            rows="3"
                            class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-slate-800 text-sm focus:outline-none"
                            placeholder="اكتب أي ملاحظات للتحقق مثل: اسم المحول، رقم الهاتف المستعلم..."
                        ></textarea>
                    </div>

                    <div
                        class="flex justify-end gap-3 pt-4 border-t border-slate-100"
                    >
                        <button
                            type="button"
                            @click="closeDetailModal"
                            class="px-4 py-2 border border-slate-200 text-slate-600 rounded-lg text-sm hover:bg-slate-50 transition cursor-pointer"
                        >
                            إلغاء
                        </button>
                        <button
                            type="submit"
                            :disabled="statusForm.processing"
                            class="px-4 py-2 bg-orange-500 hover:bg-orange-600 text-white rounded-lg text-sm font-bold shadow-sm transition cursor-pointer"
                        >
                            {{
                                statusForm.processing
                                    ? "جاري التعديل..."
                                    : "تأكيد وحفظ التغييرات"
                            }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
