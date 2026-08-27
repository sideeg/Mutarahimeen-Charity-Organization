<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Link, router } from "@inertiajs/vue3";
import { Plus, Edit2, Trash2 } from "lucide-vue-next";

defineProps({ links: Array });

const deleteLink = (id) => {
    if (confirm("هل أنت متأكد من رغبتك بحذف قناة التواصل هذه؟")) {
        router.delete("/admin/social-links/" + id);
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
                    قنوات وحسابات التواصل الاجتماعي (Social Links)
                </h2>
                <p class="text-slate-500 text-sm mt-1">
                    إضافة وعرض روابط صفحات المنظمة الرسمية (فيسبوك، إكس،
                    تليغرام).
                </p>
            </div>
            <Link
                href="/admin/social-links/create"
                class="flex items-center gap-2 px-4 py-2.5 bg-orange-500 text-white rounded-lg font-bold text-sm hover:bg-orange-600 transition"
            >
                <Plus class="w-4 h-4" />
                <span>إضافة قناة جديدة</span>
            </Link>
        </div>

        <div
            class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden"
        >
            <table class="w-full text-right border-collapse">
                <thead>
                    <tr
                        class="bg-slate-50 border-b border-slate-200 text-slate-600 text-xs font-bold uppercase tracking-wider"
                    >
                        <th class="py-4 px-6">اسم المنصة</th>
                        <th class="py-4 px-6">رابط القناة الرسمي</th>
                        <th class="py-4 px-6">اسم الأيقونة</th>
                        <th class="py-4 px-6 text-center">الحالة</th>
                        <th class="py-4 px-6 text-center">الإجراءات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-150 text-sm text-slate-700">
                    <tr
                        v-for="link in links"
                        :key="link.id"
                        class="hover:bg-slate-50/50"
                    >
                        <td class="py-4 px-6 font-bold text-slate-900">
                            {{ link.platform_name }}
                        </td>
                        <td
                            class="py-4 px-6 font-mono text-xs text-slate-500 text-left"
                            dir="ltr"
                        >
                            {{ link.url }}
                        </td>
                        <td class="py-4 px-6 font-mono text-xs">
                            {{ link.icon_name }}
                        </td>
                        <td class="py-4 px-6 text-center">
                            <span
                                class="inline-block w-2.5 h-2.5 rounded-full"
                                :class="
                                    link.is_active
                                        ? 'bg-emerald-500'
                                        : 'bg-red-400'
                                "
                            ></span>
                        </td>
                        <td class="py-4 px-6">
                            <div class="flex items-center justify-center gap-3">
                                <Link
                                    :href="
                                        '/admin/social-links/' +
                                        link.id +
                                        '/edit'
                                    "
                                    class="p-2 text-slate-500 hover:text-orange-500 hover:bg-slate-100 rounded-lg transition"
                                >
                                    <Edit2 class="w-4 h-4" />
                                </Link>
                                <button
                                    @click="deleteLink(link.id)"
                                    class="p-2 text-slate-400 hover:text-red-500 hover:bg-red-50/50 rounded-lg transition cursor-pointer"
                                >
                                    <Trash2 class="w-4 h-4" />
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </AuthenticatedLayout>
</template>
