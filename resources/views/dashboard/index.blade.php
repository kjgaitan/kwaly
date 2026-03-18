<x-app-layout>
    <div class="min-h-screen bg-[#060b08] px-3 py-4 text-white md:px-4 lg:px-5">
        <div class="w-full rounded-[24px] border border-[#26352d] bg-[#171c19] shadow-[0_0_18px_rgba(114,245,154,0.05)]">
            <div class="px-4 py-4 md:px-5 lg:px-6 lg:py-5">

                <!-- HEADER -->
                <div class="mb-5 flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
                    <div>
                        <h2 class="text-3xl font-bold tracking-tight">Dashboard</h2>
                        <p class="mt-1 text-sm text-gray-400">Resumen de tu actividad financiera</p>
                    </div>

                    <div class="flex flex-wrap items-center gap-3">
                        <select class="rounded-xl border border-[#26352d] bg-[#111613] px-4 py-2 text-sm text-white focus:outline-none focus:ring-2 focus:ring-[#72f59a]">
                            <option>Este Mes</option>
                            <option>Últimos 3 meses</option>
                            <option>Este Año</option>
                        </select>

                        <button class="relative flex h-10 w-10 items-center justify-center rounded-full border border-[#26352d] bg-[#111613] transition-all duration-200 hover:bg-[#1a211d]">
                            
                            <span class="absolute right-1 top-1 h-2.5 w-2.5 rounded-full bg-[#72f59a]"></span>
                        </button>

                        <div class="flex items-center gap-3 rounded-xl border border-[#26352d] bg-[#111613] px-3 py-2">
                            <div class="flex h-8 w-8 items-center justify-center rounded-full bg-[#72f59a] font-bold text-black">
                                {{ strtoupper(substr(Auth::user()->name ?? Auth::user()->nombre ?? 'U', 0, 1)) }}
                            </div>
                            <div class="hidden sm:block">
                                <p class="text-sm font-medium">{{ Auth::user()->name ?? Auth::user()->nombre ?? 'Usuario' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TARJETAS SUPERIORES -->
                <div class="mb-4 grid grid-cols-1 gap-4 md:grid-cols-3">
                    <div class="rounded-2xl border border-[#26352d] bg-[#171c19] p-4 shadow-[0_0_18px_rgba(114,245,154,0.05)]">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-400">Ingresos del Mes</p>
                                <h3 class="mt-1 text-2xl font-bold text-[#72f59a]">3500€</h3>
                            </div>
                            <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-[#72f59a]/15 text-lg text-[#72f59a] shadow-[0_0_18px_rgba(114,245,154,0.18)]">
                                ↑
                            </div>
                        </div>
                    </div>

                    <div class="rounded-2xl border border-[#26352d] bg-[#171c19] p-4 shadow-[0_0_18px_rgba(255,80,80,0.04)]">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-400">Gastos del Mes</p>
                                <h3 class="mt-1 text-2xl font-bold text-red-400">2340€</h3>
                            </div>
                            <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-red-400/15 text-lg text-red-400 shadow-[0_0_18px_rgba(248,113,113,0.16)]">
                                ↓
                            </div>
                        </div>
                    </div>

                    <div class="rounded-2xl border border-[#26352d] bg-[#171c19] p-4 shadow-[0_0_18px_rgba(114,245,154,0.05)]">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-400">Balance Disponible</p>
                                <h3 class="mt-1 text-2xl font-bold text-[#8bffab]">1160€</h3>
                            </div>
                            <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-[#72f59a]/15 text-lg text-[#8bffab] shadow-[0_0_18px_rgba(114,245,154,0.14)]">
                                
                            </div>
                        </div>
                    </div>
                </div>

                <!-- BLOQUE RESUMEN -->
                <div class="mb-4 rounded-2xl border border-[#26352d] bg-[#171c19] p-4 shadow-[0_0_18px_rgba(114,245,154,0.05)]">
                    <div class="flex items-start gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#72f59a]/15 text-[#72f59a]">
                            
                        </div>
                        <div>
                            <h3 class="text-base font-semibold">¿Vas por buen camino?</h3>
                            <p class="text-sm text-gray-400">
                                Según tus hábitos actuales, tienes una proyección positiva y un saldo libre de
                                <span class="font-semibold text-[#72f59a]">1160€</span> al final del mes.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- GRÁFICAS -->
                <div class="mb-4 grid grid-cols-1 gap-4 xl:grid-cols-2">
                    <!-- GASTOS POR CATEGORÍA -->
                    <div class="rounded-2xl border border-[#26352d] bg-[#171c19] p-4 shadow-[0_0_18px_rgba(114,245,154,0.05)]">
                        <h3 class="mb-4 text-base font-semibold">Gastos por Categoría</h3>

                        <div class="mb-5 flex justify-center">
                            <div class="relative flex h-44 w-44 items-center justify-center rounded-full bg-[conic-gradient(#8fffaf_0%_34%,#63d66f_34%_56%,#2e8f48_56%_71%,#55c46a_71%_84%,#4ef2ba_84%_100%)] shadow-[0_0_26px_rgba(114,245,154,0.14)]">
                                <div class="flex h-24 w-24 flex-col items-center justify-center rounded-full border border-[#26352d] bg-[#171c19]">
                                    <span class="text-xl font-bold text-[#72f59a]">2340€</span>
                                    <span class="text-[11px] text-gray-400">Total</span>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-2.5">
                            <div class="flex items-center justify-between rounded-xl border border-[#26352d] bg-[#111613] px-4 py-2.5">
                                <div class="flex items-center gap-3">
                                    <span class="h-3 w-3 rounded-full bg-[#8fffaf]"></span>
                                    <span class="text-sm">Vivienda</span>
                                </div>
                                <span class="text-sm text-gray-300">34.2% · 800€</span>
                            </div>

                            <div class="flex items-center justify-between rounded-xl border border-[#26352d] bg-[#111613] px-4 py-2.5">
                                <div class="flex items-center gap-3">
                                    <span class="h-3 w-3 rounded-full bg-[#63d66f]"></span>
                                    <span class="text-sm">Alimentación</span>
                                </div>
                                <span class="text-sm text-gray-300">22.2% · 520€</span>
                            </div>

                            <div class="flex items-center justify-between rounded-xl border border-[#26352d] bg-[#111613] px-4 py-2.5">
                                <div class="flex items-center gap-3">
                                    <span class="h-3 w-3 rounded-full bg-[#2e8f48]"></span>
                                    <span class="text-sm">Transporte</span>
                                </div>
                                <span class="text-sm text-gray-300">15.2% · 360€</span>
                            </div>

                            <div class="flex items-center justify-between rounded-xl border border-[#26352d] bg-[#111613] px-4 py-2.5">
                                <div class="flex items-center gap-3">
                                    <span class="h-3 w-3 rounded-full bg-[#55c46a]"></span>
                                    <span class="text-sm">Compras</span>
                                </div>
                                <span class="text-sm text-gray-300">14.9% · 350€</span>
                            </div>

                            <div class="flex items-center justify-between rounded-xl border border-[#26352d] bg-[#111613] px-4 py-2.5">
                                <div class="flex items-center gap-3">
                                    <span class="h-3 w-3 rounded-full bg-[#4ef2ba]"></span>
                                    <span class="text-sm">Otros</span>
                                </div>
                                <span class="text-sm text-gray-300">13.2% · 310€</span>
                            </div>
                        </div>
                    </div>

                    <!-- TENDENCIA -->
                    <div class="rounded-2xl border border-[#26352d] bg-[#171c19] p-4 shadow-[0_0_18px_rgba(114,245,154,0.05)]">
                        <div class="mb-4 flex items-start justify-between">
                            <div>
                                <h3 class="text-base font-semibold">Tendencia Mensual</h3>
                                <p class="text-sm text-gray-400">Balance Total</p>
                                <h4 class="mt-1 text-2xl font-bold text-white">2700€</h4>
                                <span class="mt-2 inline-block rounded-full bg-[#72f59a]/15 px-3 py-1 text-xs font-semibold text-[#72f59a]">
                                    +6.5%
                                </span>
                                <span class="ml-2 text-xs text-gray-400">vs último mes</span>
                            </div>

                            <div class="text-right">
                                <p class="text-[11px] text-gray-500">Actualizado</p>
                                <p class="text-sm text-gray-300">Hace 2 minutos</p>
                            </div>
                        </div>

                        <div class="relative h-64 overflow-hidden rounded-2xl border border-[#26352d] bg-[#111613]">
                            <div class="absolute inset-0 flex flex-col justify-between p-5">
                                <div class="border-t border-[#26352d]/80"></div>
                                <div class="border-t border-[#26352d]/80"></div>
                                <div class="border-t border-[#26352d]/80"></div>
                                <div class="border-t border-[#26352d]/80"></div>
                                <div class="border-t border-[#26352d]/80"></div>
                            </div>

                            <svg class="absolute inset-0 h-full w-full" viewBox="0 0 600 300" preserveAspectRatio="none">
                                <defs>
                                    <linearGradient id="lineFill" x1="0" y1="0" x2="0" y2="1">
                                        <stop offset="0%" stop-color="#72f59a" stop-opacity="0.30" />
                                        <stop offset="100%" stop-color="#72f59a" stop-opacity="0" />
                                    </linearGradient>
                                </defs>

                                <path d="M0,210 C60,180 100,190 150,185 C220,180 250,205 320,170 C390,135 440,190 500,150 C540,125 570,130 600,140 L600,300 L0,300 Z"
                                      fill="url(#lineFill)" />

                                <path d="M0,210 C60,180 100,190 150,185 C220,180 250,205 320,170 C390,135 440,190 500,150 C540,125 570,130 600,140"
                                      fill="none"
                                      stroke="#72f59a"
                                      stroke-width="4"
                                      stroke-linecap="round" />
                            </svg>

                            <div class="absolute bottom-4 left-0 right-0 flex justify-between px-5 text-[11px] text-gray-400">
                                <span>Ene</span>
                                <span>Feb</span>
                                <span>Mar</span>
                                <span>Abr</span>
                                <span>May</span>
                                <span>Jun</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SISTEMA PRESUPUESTARIO -->
                <div class="mb-4 rounded-2xl border border-[#26352d] bg-[#171c19] p-5 shadow-[0_0_22px_rgba(114,245,154,0.06)]">
                    <h3 class="mb-4 text-base font-semibold">Sistema presupuestario (50/30/20)</h3>

                    <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                        <div>
                            <div class="mb-2 flex items-center justify-between text-sm">
                                <span class="text-white">Esenciales</span>
                                <span class="font-semibold text-[#72f59a]">48%</span>
                            </div>
                            <div class="h-2.5 w-full overflow-hidden rounded-full bg-[#111613]">
                                <div class="h-full rounded-full bg-[#72f59a] shadow-[0_0_12px_rgba(114,245,154,0.22)]" style="width: 48%"></div>
                            </div>
                        </div>

                        <div>
                            <div class="mb-2 flex items-center justify-between text-sm">
                                <span class="text-white">Deseos</span>
                                <span class="font-semibold text-[#72f59a]">35%</span>
                            </div>
                            <div class="h-2.5 w-full overflow-hidden rounded-full bg-[#111613]">
                                <div class="h-full rounded-full bg-[#72f59a] shadow-[0_0_12px_rgba(114,245,154,0.18)]" style="width: 35%"></div>
                            </div>
                        </div>

                        <div>
                            <div class="mb-2 flex items-center justify-between text-sm">
                                <span class="text-white">Ahorros</span>
                                <span class="font-semibold text-[#72f59a]">17%</span>
                            </div>
                            <div class="h-2.5 w-full overflow-hidden rounded-full bg-[#111613]">
                                <div class="h-full rounded-full bg-[#72f59a] shadow-[0_0_12px_rgba(114,245,154,0.18)]" style="width: 17%"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- LOGROS -->
                <div class="mb-4 rounded-2xl border border-[#26352d] bg-[#171c19] p-5 shadow-[0_0_22px_rgba(114,245,154,0.05)]">
                    <h3 class="mb-4 text-base font-semibold">Tus Logros Financieros</h3>

                    <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                        <div class="rounded-2xl border border-[#26352d] bg-[#1b211d] p-4">
                            <div class="flex items-start gap-3">
                                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#72f59a]/15 text-[#72f59a]">
                                  
                                </div>
                                <div>
                                    <h4 class="font-semibold text-white">Ahorro Mensual</h4>
                                    <p class="text-sm text-gray-400">Ahorraste más del 20% este mes</p>
                                </div>
                            </div>
                        </div>

                        <div class="rounded-2xl border border-[#26352d] bg-[#1b211d] p-4">
                            <div class="flex items-start gap-3">
                                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#72f59a]/15 text-[#72f59a]">
                                    
                                </div>
                                <div>
                                    <h4 class="font-semibold text-white">Presupuesto Cumplido</h4>
                                    <p class="text-sm text-gray-400">No excediste tu presupuesto de ocio</p>
                                </div>
                            </div>
                        </div>

                        <div class="rounded-2xl border border-[#26352d] bg-[#1b211d] p-4">
                            <div class="flex items-start gap-3">
                                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-gray-200/10 text-gray-300">
                                    
                                </div>
                                <div>
                                    <h4 class="font-semibold text-white">Racha de 7 días</h4>
                                    <p class="text-sm text-gray-400">Registraste gastos durante 7 días seguidos</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TRANSACCIONES -->
                <div class="rounded-2xl border border-[#26352d] bg-[#171c19] p-4 shadow-[0_0_22px_rgba(114,245,154,0.05)]">
                    <div class="mb-4 flex items-center justify-between">
                        <h3 class="text-base font-semibold">Transacciones Recientes</h3>
                        <a href="#" class="text-sm text-[#72f59a] hover:underline">Ver todas</a>
                    </div>

                    <div class="space-y-2.5">
                        <div class="flex items-center justify-between rounded-xl border border-[#26352d] bg-[#111613] px-4 py-3">
                            <div class="flex items-center gap-4">
                                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-red-400/15 text-red-400">
                                    ↓
                                </div>
                                <div>
                                    <p class="font-medium">Supermercado</p>
                                    <p class="text-sm text-gray-400">Alimentación</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="font-semibold text-red-400">-45€</p>
                                <p class="text-xs text-gray-400">Hoy</p>
                            </div>
                        </div>

                        <div class="flex items-center justify-between rounded-xl border border-[#26352d] bg-[#111613] px-4 py-3">
                            <div class="flex items-center gap-4">
                                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-[#72f59a]/15 text-[#72f59a]">
                                    ↑
                                </div>
                                <div>
                                    <p class="font-medium">Nómina</p>
                                    <p class="text-sm text-gray-400">Salario</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="font-semibold text-[#72f59a]">+2600€</p>
                                <p class="text-xs text-gray-400">Ayer</p>
                            </div>
                        </div>

                        <div class="flex items-center justify-between rounded-xl border border-[#26352d] bg-[#111613] px-4 py-3">
                            <div class="flex items-center gap-4">
                                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-red-400/15 text-red-400">
                                    ↓
                                </div>
                                <div>
                                    <p class="font-medium">Gasolina</p>
                                    <p class="text-sm text-gray-400">Transporte</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="font-semibold text-red-400">-25€</p>
                                <p class="text-xs text-gray-400">Ayer</p>
                            </div>
                        </div>

                        <div class="flex items-center justify-between rounded-xl border border-[#26352d] bg-[#111613] px-4 py-3">
                            <div class="flex items-center gap-4">
                                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-red-400/15 text-red-400">
                                    ↓
                                </div>
                                <div>
                                    <p class="font-medium">Netflix</p>
                                    <p class="text-sm text-gray-400">Suscripciones</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="font-semibold text-red-400">-15€</p>
                                <p class="text-xs text-gray-400">Hace 2 días</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>