<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Link, router } from "@inertiajs/vue3";
import { Plus, Edit2, Trash2 } from "lucide-vue-next";

defineProps({
    users: Array,
});

const deleteUser = (id) => {
    if (confirm("هل أنت متأكد من رغبتك بحذف هذا الحساب الإداري نهائياً؟")) {
        router.delete("/admin/users/" + id);
    }
};
</script>

<template>
    <AuthenticatedLayout>
        <div
            class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8 gap-4"
        >
            <div>
                <h2 class="text-2xl font-bold text-slate-800">
                    إدارة مشرفي النظام والمنظمة
                </h2>
                <p class="text-slate-500 text-sm mt-1">
                    عرض وصلاحيات الطاقم التشغيلي المسؤول عن المحتوى والعمليات
                    المالية.
                </p>
            </div>
            <Link
                href="/admin/users/create"
                class="flex items-center gap-2 px-4 py-2.5 bg-orange-500 text-white rounded-lg font-bold text-sm hover:bg-orange-600 transition shadow-sm cursor-pointer self-start"
            >
                <Plus class="w-4 h-4" />
                <span>إضافة مشرف جديد</span>
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
                            <th class="py-4 px-6">الاسم والبريد الإلكتروني</th>
                            <th class="py-4 px-6">الصلاحيات ودور المستخدم</th>
                            <th class="py-4 px-6">آخر تسجيل دخول</th>
                            <th class="py-4 px-6 text-center">الحالة</th>
                            <th class="py-4 px-6 text-center">الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody
                        class="divide-y divide-slate-150 text-sm text-slate-700"
                    >
                        <tr
                            v-for="user in users"
                            :key="user.id"
                            class="hover:bg-slate-50/50"
                        >
                            <td class="py-4 px-6">
                                <span class="block font-bold text-slate-900">{{
                                    user.name
                                }}</span>
                                <span
                                    class="block text-xs text-slate-400 mt-0.5"
                                    >{{ user.email }}</span
                                >
                            </td>
                            <td class="py-4 px-6">
                                <span
                                    class="inline-block px-3 py-1 rounded-full text-xs font-bold"
                                    :class="{
                                        'bg-purple-100 text-purple-800':
                                            user.role === 'super_admin',
                                        'bg-blue-100 text-blue-800':
                                            user.role === 'content_editor',
                                        'bg-emerald-100 text-emerald-800':
                                            user.role === 'finance',
                                    }"
                                >
                                    {{
                                        user.role === "super_admin"
                                            ? "مدير عام بالنظام"
                                            : user.role === "finance"
                                            ? "المشرف المالي"
                                            : "محرر محتوى"
                                    }}
                                </span>
                            </td>
                            <td
                                class="py-4 px-6 font-mono text-slate-400 text-xs"
                            >
                                {{ user.last_login || "لم يسجل دخول بعد" }}
                            </td>
                            <td class="py-4 px-6 text-center">
                                <span
                                    class="inline-block w-2 h-2 rounded-full"
                                    :class="
                                        user.is_active
                                            ? 'bg-emerald-500'
                                            : 'bg-red-400'
                                    "
                                    :title="user.is_active ? 'نشط' : 'معطل'"
                                ></span>
                            </td>
                            <td class="py-4 px-6">
                                <div
                                    class="flex items-center justify-center gap-3"
                                >
                                    <Link
                                        :href="
                                            '/admin/users/' + user.id + '/edit'
                                        "
                                        class="p-2 text-slate-500 hover:text-orange-500 hover:bg-slate-100 rounded-lg transition"
                                        title="تعديل"
                                    >
                                        <Edit2 class="w-4 h-4" />
                                    </Link>
                                    <button
                                        @click="deleteUser(user.id)"
                                        class="p-2 text-slate-400 hover:text-red-500 hover:bg-red-50/50 rounded-lg transition cursor-pointer"
                                        title="حذف"
                                    >
                                        <Trash2 class="w-4 h-4" />
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
