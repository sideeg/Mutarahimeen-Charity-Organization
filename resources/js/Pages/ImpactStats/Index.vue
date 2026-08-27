<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Link, router } from "@inertiajs/vue3";
import { Plus, Edit2, Trash2 } from "lucide-vue-next";

defineProps({ stats: Array });

const deleteStat = (id) => {
    if (confirm("هل أنت متأكد من حذف مؤشر الأثر هذا؟")) {
        router.delete("/admin/impact-stats/" + id);
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
                    إحصائيات ومؤشرات الأثر (Impact Stats)
                </h2>
                <p class="text-slate-500 text-sm mt-1">
                    إضافة وعرض أرقام الإنجاز الإنساني (مثل: الآبار المحفورة،
                    الوجبات الموزعة).
                </p>
            </div>
            <Link
                href="/admin/impact-stats/create"
                class="flex items-center gap-2 px-4 py-2.5 bg-orange-500 text-white rounded-lg font-bold text-sm hover:bg-orange-600 transition"
            >
                <Plus class="w-4 h-4" />
                <span>إضافة مؤشر جديد</span>
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
                        <th class="py-4 px-6">المؤشر البصري</th>
                        <th class="py-4 px-6">القيمة العددية</th>
                        <th class="py-4 px-6">المصدر</th>
                        <th class="py-4 px-6">الترتيب</th>
                        <th class="py-4 px-6 text-center">الحالة</th>
                        <th class="py-4 px-6 text-center">الإجراءات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-150 text-sm text-slate-700">
                    <tr
                        v-for="stat in stats"
                        :key="stat.id"
                        class="hover:bg-slate-50/50"
                    >
                        <td class="py-4 px-6 font-bold text-slate-900">
                            {{ stat.label_ar }}
                        </td>
                        <td
                            class="py-4 px-6 font-mono font-bold text-slate-800"
                        >
                            {{ stat.number_value }}{{ stat.suffix }}
                        </td>
                        <td class="py-4 px-6">
                            <span
                                class="inline-block px-2.5 py-0.5 rounded text-xs"
                                :class="
                                    stat.source_type === 'manual'
                                        ? 'bg-blue-100 text-blue-800'
                                        : 'bg-purple-100 text-purple-800'
                                "
                            >
                                {{
                                    stat.source_type === "manual"
                                        ? "يدوي"
                                        : "محسوب تلقائياً"
                                }}
                            </span>
                        </td>
                        <td class="py-4 px-6 font-mono">
                            {{ stat.display_order }}
                        </td>
                        <td class="py-4 px-6 text-center">
                            <span
                                class="inline-block w-2.5 h-2.5 rounded-full"
                                :class="
                                    stat.is_active
                                        ? 'bg-emerald-500'
                                        : 'bg-red-400'
                                "
                            ></span>
                        </td>
                        <td class="py-4 px-6">
                            <div class="flex items-center justify-center gap-3">
                                <Link
                                    :href="
                                        '/admin/impact-stats/' +
                                        stat.id +
                                        '/edit'
                                    "
                                    class="p-2 text-slate-500 hover:text-orange-500 hover:bg-slate-100 rounded-lg transition"
                                >
                                    <Edit2 class="w-4 h-4" />
                                </Link>
                                <button
                                    @click="deleteStat(stat.id)"
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
