<?php

return [
    // مصفوفة الكلمات المشينة الأساسية (يمكن للمستخدم تعديلها بعد النشر)
    'words' => [
        // أمثلة (ضع القائمة الحقيقية هنا)
        'شتم1',
        'شتم2',
        // ... استخدم كلمات مناسبة للبيئة الليبية
    ],

    // الاستبدال الافتراضي — يمكن أن يكون سلسلة أو دالة
    'replacement' => '[تم الحجب]',

    // إعدادات المعالجة: تطبيع أحرف، إزالة تشكيل، تجاهل حالة الحروف
    'normalize' => true,
    'strip_diacritics' => true,
    'ignore_case' => true,

    // هل نقوم بمطابقة الحروف اللاتينية المكتوبة بالعربية (transliteration)
    'latin_transliteration' => true,

    // تحميل كلمات إضافية من ملف نصي داخل resources/words
    'load_from_file' => true,
    'words_file' => __DIR__ . '/../resources/words/libyan_badwords.txt',
];
