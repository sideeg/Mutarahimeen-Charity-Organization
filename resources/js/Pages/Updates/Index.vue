<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Link, router } from "@inertiajs/vue3";
import { Plus, Edit2, Trash2, Calendar } from "lucide-vue-next";

defineProps({
    updates: Array,
});

const deleteUpdate = (id) => {
    if (confirm("هل أنت متأكد من حذف هذا التقرير الميداني؟")) {
        router.delete("/admin/updates/" + id);
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
                    التحديثات والتقارير الميدانية للمشاريع
                </h2>
                <p class="text-slate-500 text-sm mt-1">
                    عرض وتوثيق مراحل التنفيذ وتقديم التقارير البصرية والوصفية
                    للمتبرعين.
                </p>
            </div>
            <Link
                href="/admin/updates/create"
                class="flex items-center gap-2 px-4 py-2.5 bg-orange-500 text-white rounded-lg font-bold text-sm hover:bg-orange-600 transition shadow-sm cursor-pointer"
            >
                <Plus class="w-4 h-4" />
                <span>إضافة تقرير ميداني</span>
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
                        <th class="py-4 px-6">عنوان التقرير</th>
                        <th class="py-4 px-6">المشروع المرتبط</th>
                        <th class="py-4 px-6">تاريخ النشر الميداني</th>
                        <th class="py-4 px-6 text-center">الإجراءات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-150 text-sm text-slate-700">
                    <tr
                        v-for="up in updates"
                        :key="up.id"
                        class="hover:bg-slate-50/50"
                    >
                        <td class="py-4 px-6 font-bold text-slate-900">
                            {{ up.title_ar }}
                        </td>
                        <td class="py-4 px-6 text-slate-600 font-semibold">
                            {{ up.project?.title_ar }}
                        </td>
                        <td
                            class="py-4 px-6 font-mono text-slate-500 text-xs flex items-center gap-2 mt-1"
                        >
                            <Calendar class="w-4 h-4 text-slate-400" />
                            {{ up.published_date }}
                        </td>
                        <td class="py-4 px-6">
                            <div class="flex items-center justify-center gap-3">
                                <Link
                                    :href="'/admin/updates/' + up.id + '/edit'"
                                    class="p-2 text-slate-500 hover:text-orange-500 hover:bg-slate-100 rounded-lg transition"
                                >
                                    <Edit2 class="w-4 h-4" />
                                </Link>
                                <button
                                    @click="deleteUpdate(up.id)"
                                    class="p-2 text-slate-400 hover:text-red-500 hover:bg-red-50/50 rounded-lg transition cursor-pointer"
                                >
                                    <Trash2 class="w-4 h-4" />
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr v-if="updates.length === 0">
                        <td colspan="4" class="py-8 text-center text-slate-400">
                            لا توجد تحديثات ميدانية مسجلة حتى الآن.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </AuthenticatedLayout>
</template>
