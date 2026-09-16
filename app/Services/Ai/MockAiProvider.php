<?php

namespace App\Services\Ai;

class MockAiProvider implements AiProviderInterface
{
    public function generate(string $prompt, array $context = []): string
    {
        $type = $context['type'] ?? 'general';

        switch ($type) {
            case 'village_profile':
                $villageName = $context['village_name'] ?? 'Desa';
                return "{$villageName} merupakan desa yang bertransformasi menuju desa cerdas dan mandiri. Didukung oleh kekayaan alam pertanian yang subur serta kerajinan UMKM unggulan, desa ini terus mengintegrasikan potensi lokal dengan inovasi digital untuk memperluas akses pasar dan meningkatkan kesejahteraan warganya.";

            case 'program_description':
                $title = $context['title'] ?? 'Program Kerja';
                return "Program '{$title}' dirancang untuk menjawab tantangan nyata di masyarakat desa melalui pendekatan partisipatif. Pelaksanaan program mengedepankan transfer keterampilan, pendampingan intensif, serta pembuatan aset digital berkelanjutan yang dapat diteruskan pengelolaannya oleh perangkat desa dan kelompok pemuda lokal.";

            case 'impact_summary':
                return "Melalui sinergi mahasiswa KKN bersama masyarakat dan aparatur desa, seluruh target luaran berhasil diselesaikan dengan baik. Pencapaian ini memberikan dampak berkelanjutan pada keterbukaan informasi desa, keterkenalan produk UMKM lokal secara daring, serta penguatan kesiapan digital desa ke depan.";

            default:
                return "Draft narasi telah disusun secara profesional berdasarkan data observasi lapangan, mengutamakan kejelasan informasi, konsistensi data, dan etika komunikasi publik.";
        }
    }
}
