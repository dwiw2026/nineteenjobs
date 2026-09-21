<?php

namespace Database\Seeders;

use App\Models\CandidateProfile;
use App\Models\Company;
use App\Models\JobListing;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── Admin ──────────────────────────────────────────────────
        $admin = User::firstOrCreate(
            ['email' => 'admin@nineteenjobs.id'],
            [
                'name'              => 'Admin NineteenJobs',
                'password'          => Hash::make('Admin123!'),
                'role'              => 'admin',
                'email_verified_at' => now(),
            ]
        );

        // ── Employers + Companies ──────────────────────────────────
        $employers = [
            ['name' => 'Budi Santoso', 'email' => 'budi@kitakarya.id', 'company' => 'KitaKarya Digital',
             'industry' => 'Teknologi', 'size' => 'medium', 'location' => 'Surabaya', 'verified' => true],
            ['name' => 'Sari Dewi', 'email' => 'sari@lokastudio.id', 'company' => 'Loka Studio',
             'industry' => 'Desain & Kreatif', 'size' => 'small', 'location' => 'Jakarta', 'verified' => true],
            ['name' => 'Ahmad Fauzi', 'email' => 'ahmad@majubersama.id', 'company' => 'Maju Bersama',
             'industry' => 'E-commerce', 'size' => 'large', 'location' => 'Bandung', 'verified' => true],
            ['name' => 'Rina Putri', 'email' => 'rina@nusadata.id', 'company' => 'Nusa Data',
             'industry' => 'Data & Analitik', 'size' => 'medium', 'location' => 'Jakarta', 'verified' => false],
            ['name' => 'Dian Prasetyo', 'email' => 'dian@techforward.id', 'company' => 'TechForward',
             'industry' => 'SaaS', 'size' => 'startup', 'location' => 'Yogyakarta', 'verified' => true],
        ];

        $companies = [];
        foreach ($employers as $data) {
            $user = User::firstOrCreate(
                ['email' => $data['email']],
                [
                    'name'              => $data['name'],
                    'password'          => Hash::make('password'),
                    'role'              => 'employer',
                    'email_verified_at' => now(),
                ]
            );

            $company = Company::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'name'        => $data['company'],
                    'slug'        => Str::slug($data['company']),
                    'industry'    => $data['industry'],
                    'size'        => $data['size'],
                    'location'    => $data['location'],
                    'description' => "Perusahaan {$data['industry']} terkemuka di Indonesia yang berfokus pada inovasi dan pertumbuhan.",
                    'tagline'     => 'Inovasi untuk Indonesia',
                    'verified_at' => $data['verified'] ? now() : null,
                ]
            );

            $companies[$data['company']] = $company;
        }

        // ── Job Listings ───────────────────────────────────────────
        $jobs = [
            [
                'company' => 'KitaKarya Digital',
                'title' => 'Frontend Developer',
                'skills_required' => ['React', 'JavaScript', 'TypeScript', 'CSS', 'HTML'],
                'salary_min' => 7_000_000, 'salary_max' => 10_000_000,
                'location' => 'Surabaya', 'work_type' => 'hybrid',
                'experience_level' => 'mid', 'experience_years_min' => 2,
                'description' => 'Kami mencari Frontend Developer yang passionate untuk membangun produk digital yang digunakan jutaan orang Indonesia.',
            ],
            [
                'company' => 'Loka Studio',
                'title' => 'Product Designer',
                'skills_required' => ['Figma', 'UI/UX', 'Prototyping', 'User Research', 'Design System'],
                'salary_min' => 8_000_000, 'salary_max' => 12_000_000,
                'location' => 'Jakarta', 'work_type' => 'remote',
                'experience_level' => 'mid', 'experience_years_min' => 2,
                'description' => 'Bergabunglah dengan tim desain kami untuk menciptakan pengalaman pengguna yang indah dan intuitif.',
            ],
            [
                'company' => 'Maju Bersama',
                'title' => 'Growth Marketing Lead',
                'skills_required' => ['Digital Marketing', 'SEO', 'Analytics', 'Content Strategy', 'SEM'],
                'salary_min' => 9_000_000, 'salary_max' => 14_000_000,
                'location' => 'Bandung', 'work_type' => 'onsite',
                'experience_level' => 'senior', 'experience_years_min' => 4,
                'description' => 'Pimpin strategi pertumbuhan digital kami dan bawa brand ke level berikutnya.',
            ],
            [
                'company' => 'Nusa Data',
                'title' => 'Data Analyst',
                'skills_required' => ['SQL', 'Python', 'Tableau', 'Statistics', 'Excel'],
                'salary_min' => 8_000_000, 'salary_max' => 11_000_000,
                'location' => 'Jakarta', 'work_type' => 'hybrid',
                'experience_level' => 'junior', 'experience_years_min' => 1,
                'description' => 'Analisis data untuk membantu pengambilan keputusan bisnis yang lebih baik.',
            ],
            [
                'company' => 'TechForward',
                'title' => 'Backend Developer (Laravel)',
                'skills_required' => ['Laravel', 'PHP', 'MySQL', 'REST API', 'Docker'],
                'salary_min' => 8_000_000, 'salary_max' => 13_000_000,
                'location' => 'Yogyakarta', 'work_type' => 'remote',
                'experience_level' => 'mid', 'experience_years_min' => 2,
                'description' => 'Bangun backend yang solid dan scalable untuk platform SaaS kami.',
            ],
            [
                'company' => 'KitaKarya Digital',
                'title' => 'Mobile Developer (React Native)',
                'skills_required' => ['React Native', 'JavaScript', 'TypeScript', 'Redux', 'iOS', 'Android'],
                'salary_min' => 9_000_000, 'salary_max' => 14_000_000,
                'location' => 'Surabaya', 'work_type' => 'hybrid',
                'experience_level' => 'senior', 'experience_years_min' => 3,
                'description' => 'Kembangkan aplikasi mobile yang digunakan ribuan pengguna setiap hari.',
            ],
        ];

        foreach ($jobs as $jobData) {
            $company = $companies[$jobData['company']];
            JobListing::firstOrCreate(
                ['company_id' => $company->id, 'title' => $jobData['title']],
                [
                    'slug'               => Str::slug($jobData['title']) . '-' . Str::random(6),
                    'description'        => $jobData['description'],
                    'requirements'       => "- Pengalaman minimal {$jobData['experience_years_min']} tahun\n- Menguasai " . implode(', ', array_slice($jobData['skills_required'], 0, 3)) . "\n- Kemampuan komunikasi yang baik\n- Mampu bekerja dalam tim",
                    'skills_required'    => $jobData['skills_required'],
                    'salary_min'         => $jobData['salary_min'],
                    'salary_max'         => $jobData['salary_max'],
                    'location'           => $jobData['location'],
                    'work_type'          => $jobData['work_type'],
                    'employment_type'    => 'full_time',
                    'experience_level'   => $jobData['experience_level'],
                    'experience_years_min' => $jobData['experience_years_min'],
                    'status'             => 'published',
                    'published_at'       => now()->subDays(rand(1, 14)),
                    'expires_at'         => now()->addDays(30),
                ]
            );
        }

        // ── Sample job seekers ─────────────────────────────────────
        $seekers = [
            [
                'name' => 'Rizky Pratama', 'email' => 'rizky@example.com',
                'skills' => ['React', 'JavaScript', 'CSS', 'HTML', 'Vue'],
                'experience_years' => 3, 'location' => 'Surabaya',
                'headline' => 'Frontend Developer · 3 years React experience',
            ],
            [
                'name' => 'Putri Maharani', 'email' => 'putri@example.com',
                'skills' => ['Figma', 'UI/UX', 'Prototyping', 'Illustrator'],
                'experience_years' => 2, 'location' => 'Jakarta',
                'headline' => 'Product Designer · UI/UX enthusiast',
            ],
        ];

        foreach ($seekers as $data) {
            $user = User::firstOrCreate(
                ['email' => $data['email']],
                [
                    'name'              => $data['name'],
                    'password'          => Hash::make('password'),
                    'role'              => 'job_seeker',
                    'email_verified_at' => now(),
                ]
            );

            CandidateProfile::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'headline'        => $data['headline'],
                    'skills'          => $data['skills'],
                    'experience_years'=> $data['experience_years'],
                    'location'        => $data['location'],
                    'availability'    => 'open',
                    'profile_completeness' => 75,
                ]
            );
        }

        $this->command->info('✅ NineteenJobs seeded: 1 admin, ' . count($employers) . ' employers, ' . count($jobs) . ' jobs, ' . count($seekers) . ' candidates.');
    }
}
