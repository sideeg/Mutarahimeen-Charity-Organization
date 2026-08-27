<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Link, router } from "@inertiajs/vue3";
import { Plus, Edit2, Trash2 } from "lucide-vue-next";

defineProps({
    projects: Array,
});

const deleteProject = (id) => {
    if (confirm("هل أنت متأكد من رغبتك بحذف هذا المشروع بالكامل؟")) {
        router.delete("/admin/projects/" + id);
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
                    إدارة الملف التعريفي للمشاريع
                </h2>
                <p class="text-slate-500 text-sm mt-1">
                    تعديل، إضافة، أو إيقاف مشاريع المنظمة وعرض التقدم المالي
                    الحالي.
                </p>
            </div>
            <Link
                href="/admin/projects/create"
                class="flex items-center gap-2 px-4 py-2.5 bg-orange-500 text-white rounded-lg font-bold text-sm hover:bg-orange-600 transition shadow-sm cursor-pointer self-start"
            >
                <Plus class="w-4 h-4" />
                <span>إضافة مشروع جديد</span>
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
                            <th class="py-4 px-6">عنوان المشروع</th>
                            <th class="py-4 px-6">النوع والولاية</th>
                            <th class="py-4 px-6">المبلغ المطلوب</th>
                            <th class="py-4 px-6">المدفوع المؤكد</th>
                            <th class="py-4 px-6">الحالة</th>
                            <th class="py-4 px-6 text-center">الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody
                        class="divide-y divide-slate-150 text-sm text-slate-700"
                    >
                        <tr
                            v-for="project in projects"
                            :key="project.id"
                            class="hover:bg-slate-50/50"
                        >
                            <td class="py-4 px-6 font-bold text-slate-900">
                                {{ project.title_ar }}
                            </td>
                            <td class="py-4 px-6">
                                <span
                                    class="block text-xs font-bold text-slate-600"
                                    >{{ project.category?.name_ar }}</span
                                >
                                <span
                                    class="block text-[10px] text-slate-400 mt-0.5"
                                    >{{
                                        project.governorate || "عموم السودان"
                                    }}</span
                                >
                            </td>
                            <td
                                class="py-4 px-6 font-mono font-bold text-slate-800"
                            >
                                {{
                                    project.target_amount
                                        ? new Intl.NumberFormat("ar-SD").format(
                                              project.target_amount
                                          ) + " ج.س"
                                        : "غير محدد"
                                }}
                            </td>
                            <td
                                class="py-4 px-6 font-mono text-emerald-600 font-bold"
                            >
                                {{
                                    new Intl.NumberFormat("ar-SD").format(
                                        project.raised_amount
                                    )
                                }}
                                ج.س
                            </td>
                            <td class="py-4 px-6">
                                <span
                                    class="inline-block px-3 py-1 rounded-full text-xs font-bold"
                                    :class="{
                                        'bg-emerald-100 text-emerald-800':
                                            project.status === 'active',
                                        'bg-blue-100 text-blue-800':
                                            project.status === 'completed',
                                        'bg-slate-100 text-slate-800':
                                            project.status === 'paused',
                                    }"
                                >
                                    {{
                                        project.status === "active"
                                            ? "نشط"
                                            : project.status === "completed"
                                            ? "مكتمل"
                                            : "موقوف"
                                    }}
                                </span>
                            </td>
                            <td class="py-4 px-6">
                                <div
                                    class="flex items-center justify-center gap-3"
                                >
                                    <Link
                                        :href="
                                            '/admin/projects/' +
                                            project.id +
                                            '/edit'
                                        "
                                        class="p-2 text-slate-500 hover:text-orange-500 hover:bg-slate-100 rounded-lg transition"
                                        title="تعديل"
                                    >
                                        <Edit2 class="w-4 h-4" />
                                    </Link>
                                    <button
                                        @click="deleteProject(project.id)"
                                        class="p-2 text-slate-400 hover:text-red-500 hover:bg-red-50/50 rounded-lg transition cursor-pointer"
                                        title="حذف"
                                    >
                                        <Trash2 class="w-4 h-4" />
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr v-if="projects.length === 0">
                            <td
                                colspan="6"
                                class="py-8 text-center text-slate-400"
                            >
                                لا توجد مشاريع مضافة حالياً.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
