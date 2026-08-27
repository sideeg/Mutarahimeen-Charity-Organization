<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { useForm, Link } from "@inertiajs/vue3";
import { ArrowRight, Save } from "lucide-vue-next";

const props = defineProps({
    user: Object,
});

const isEditing = !!props.user;

const form = useForm({
    name: props.user?.name || "",
    email: props.user?.email || "",
    password: "", // Kept empty unless password update is required
    role: props.user?.role || "content_editor",
    is_active: props.user ? !!props.user.is_active : true,
});

const submit = () => {
    if (isEditing) {
        form.post("/admin/users/" + props.user.id);
    } else {
        form.post("/admin/users");
    }
};
</script>

<template>
    <AuthenticatedLayout>
        <div class="mb-8 flex items-center gap-4">
            <Link
                href="/admin/users"
                class="p-2 bg-white border border-slate-200 rounded-lg text-slate-600 hover:bg-slate-50 transition"
            >
                <ArrowRight class="w-5 h-5" />
            </Link>
            <div>
                <h2 class="text-2xl font-bold text-slate-800">
                    {{ isEditing ? "تعديل صلاحيات المشرف" : "إضافة مشرف جديد" }}
                </h2>
                <p class="text-slate-500 text-sm mt-1">
                    تعديل البريد الإلكتروني، كلمات المرور، ومستويات الصلاحية
                    الفنية والمالية.
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
                        >الاسم الثلاثي للمسؤول *</label
                    >
                    <input
                        type="text"
                        v-model="form.name"
                        required
                        pattern="^[\p{L}\s']+$"
                        title="يرجى إدخال اسم صحيح يحتوي على حروف فقط."
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-slate-800 text-sm focus:outline-none"
                    />
                    <p
                        v-if="form.errors.name"
                        class="text-xs text-red-400 mt-1"
                    >
                        {{ form.errors.name }}
                    </p>
                </div>

                <div>
                    <label
                        class="block text-sm font-semibold text-slate-700 mb-2"
                        >البريد الإلكتروني *</label
                    >
                    <input
                        type="email"
                        v-model="form.email"
                        required
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-slate-800 text-sm focus:outline-none"
                    />
                    <p
                        v-if="form.errors.email"
                        class="text-xs text-red-400 mt-1"
                    >
                        {{ form.errors.email }}
                    </p>
                </div>

                <div>
                    <label
                        class="block text-sm font-semibold text-slate-700 mb-2"
                        >كلمة المرور
                        {{
                            isEditing ? "(اتركها فارغة لعدم التغيير)" : "*"
                        }}</label
                    >
                    <input
                        type="password"
                        v-model="form.password"
                        :required="!isEditing"
                        minlength="6"
                        title="يجب أن تتكون كلمة المرور من 6 أحرف على الأقل."
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-slate-800 text-sm focus:outline-none text-left font-mono"
                    />
                    <p
                        v-if="form.errors.password"
                        class="text-xs text-red-400 mt-1"
                    >
                        {{ form.errors.password }}
                    </p>
                </div>

                <div>
                    <label
                        class="block text-sm font-semibold text-slate-700 mb-2"
                        >دور مستوى الصلاحية التشغيلية *</label
                    >
                    <select
                        v-model="form.role"
                        required
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-slate-800 text-sm focus:outline-none"
                    >
                        <option value="super_admin">
                            مدير نظام عام (Super Admin)
                        </option>
                        <option value="content_editor">
                            محرر وناشر محتوى (Content Editor)
                        </option>
                        <option value="finance">
                            مشرف تبرعات مالي (Finance Specialist)
                        </option>
                    </select>
                </div>

                <div class="pt-4 flex items-center gap-6">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input
                            type="checkbox"
                            v-model="form.is_active"
                            class="w-4 h-4 text-orange-500 border-slate-300 rounded focus:ring-orange-500"
                        />
                        <span class="text-sm font-semibold text-slate-700"
                            >تفعيل حساب المشرف بالعمل حالياً</span
                        >
                    </label>
                </div>
            </div>

            <div class="flex justify-end pt-4 border-t border-slate-100">
                <button
                    type="submit"
                    :disabled="form.processing"
                    class="flex items-center gap-2 px-6 py-2.5 bg-orange-500 hover:bg-orange-600 text-white font-bold text-sm rounded-lg shadow-sm transition cursor-pointer"
                >
                    <Save class="w-4 h-4" />
                    <span>{{
                        form.processing ? "جاري الحفظ..." : "حفظ بيانات المشرف"
                    }}</span>
                </button>
            </div>
        </form>
    </AuthenticatedLayout>
</template>
