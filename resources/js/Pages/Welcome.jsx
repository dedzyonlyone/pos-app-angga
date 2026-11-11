import { Head } from '@inertiajs/react';

export default function Welcome() {
    return (
        <>
            <Head title="POS App Modern" />
            <div style={{ minHeight: '100vh', backgroundColor: '#0f172a', color: 'white', display: 'flex', flexDirection: 'column', alignItems: 'center', justifyContent: 'center', fontFamily: 'sans-serif' }}>
                <h1 style={{ fontSize: '48px', fontWeight: 'bold', marginBottom: '20px', textAlign: 'center' }}>
                    Tampilan Berhasil Diubah!
                </h1>
                <p style={{ color: '#94a3b8', fontSize: '18px', marginBottom: '40px' }}>
                    Ini bukti kalau React & Inertia-nya jalan.
                </p>
                <a href="/login" style={{ backgroundColor: '#4f46e5', color: 'white', padding: '15px 30px', borderRadius: '8px', textDecoration: 'none', fontWeight: 'bold' }}>
                    Masuk ke Sistem POS
                </a>
            </div>
        </>
    );
}