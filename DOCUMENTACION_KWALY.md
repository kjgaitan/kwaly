# DOCUMENTACIÓN TÉCNICA - APLICACIÓN KWALY

## 📋 TABLA DE CONTENIDOS

1. [Información General](#información-general)
2. [Descripción del Sistema](#descripción-del-sistema)
3. [Arquitectura y Estructura](#arquitectura-y-estructura)
4. [Modelos de Datos](#modelos-de-datos)
5. [Módulos Principales](#módulos-principales)
6. [Servicios](#servicios)
7. [Rutas y Endpoints](#rutas-y-endpoints)
8. [Estructura de Directorios](#estructura-de-directorios)
9. [Stack Tecnológico](#stack-tecnológico)
10. [Guía de Instalación](#guía-de-instalación)
11. [Flujos Principales](#flujos-principales)

---

## 🎯 INFORMACIÓN GENERAL

**Nombre del Proyecto:** Kwaly  
**Descripción:** Aplicación web de gestión financiera personal desarrollada con Laravel 12  
**Propósito:** Organizar transacciones, presupuestos, facturas, metas financieras, reportes, educación financiera, calendario y gastos compartidos  
**Versión PHP Requerida:** 8.2+  
**Base de Datos:** MySQL/MariaDB  

---

## 📖 DESCRIPCIÓN DEL SISTEMA

### Objetivo Principal

Kwaly es una plataforma integral de gestión financiera personal que permite a los usuarios:
- Registrar y clasificar sus movimientos financieros (ingresos y gastos)
- Crear presupuestos mensuales utilizando la metodología 50/30/20
- Establecer y monitorear metas financieras con aportaciones
- Gestionar facturas y sus pagos
- Aprender sobre educación financiera mediante módulos interactivos
- Compartir gastos con otros usuarios en grupos
- Generar reportes y análisis de su comportamiento financiero
- Personalizar sus preferencias y configuraciones

### Funcionalidades Principales

#### 💰 Gestión de Transacciones
- Registro de ingresos y gastos
- Clasificación por categorías personalizables
- Múltiples cuentas financieras
- Búsqueda y filtrado avanzado
- Asociación con métodos de pago

#### 📊 Presupuestos
- Creación de presupuestos mensuales
- Sistema de "sobres" (Envelope Budget) personalizado
- Distribución automática según regla 50/30/20
- Monitoreo de gasto vs. presupuesto
- Categorización (necesidades, deseos, ahorro)

#### 🎯 Metas Financieras
- Creación de metas con montos y plazos
- Registro de aportaciones
- Seguimiento de progreso
- Estados (activa, completada, pausada)
- Prioridades (baja, media, alta)

#### 📄 Facturas
- Registro de facturas recurrentes
- Estados (pendiente, pagada, vencida)
- Frecuencias (única, mensual, anual)
- Marcado de pagos realizados

#### 🎓 Educación Financiera
- Módulos educativos con diferentes niveles
- Lecciones interactivas con contenido educativo
- Seguimiento de progreso de aprendizaje
- Certificación de completitud

#### 👥 Gastos Compartidos
- Creación de grupos de gasto
- Gestión de miembros con roles
- Distribución automática de gastos
- Cálculo de deudas/créditos por miembro

#### 📅 Calendario Financiero
- Visualización de eventos financieros próximos
- Fechas límite de metas
- Facturas por vencer

#### 📈 Reportes y Análisis
- Reportes de ingresos/gastos mensuales y anuales
- Desglose de gastos por categoría
- Análisis de tendencias
- Gráficos comparativos

---

## 🏗️ ARQUITECTURA Y ESTRUCTURA

### Patrones de Diseño Implementados

- **Service Layer Pattern**: Lógica de negocio centralizada en servicios
- **Repository Pattern**: Abstracción de datos mediante Eloquent
- **Request Validation Pattern**: Validación con Form Requests
- **Middleware Pattern**: Protección de rutas y autenticación
- **Helper Functions**: Funciones reutilizables para operaciones comunes

### Principios Arquitectónicos

- **Separación de Responsabilidades**: Controladores → Servicios → Modelos
- **DRY (Don't Repeat Yourself)**: Código reutilizable y bien estructurado
- **SOLID**: Aplicación de principios SOLID en diseño de clases
- **Seguridad**: Scopeo de datos por usuario, validaciones, autenticación
- **Mantenibilidad**: Código limpio y bien documentado

### Estructura de Capas

```
┌─────────────────────────────────────┐
│         Rutas (Web/API)             │
├─────────────────────────────────────┤
│  Controladores HTTP (Controllers)   │
├─────────────────────────────────────┤
│  Servicios (Services/Business Logic)│
├─────────────────────────────────────┤
│   Modelos Eloquent (Models/ORM)     │
├─────────────────────────────────────┤
│    Base de Datos (MySQL/MariaDB)    │
└─────────────────────────────────────┘
```

---

## 🗄️ MODELOS DE DATOS

### Diagrama de Relaciones

```
USUARIOS
  ├─→ Categorías (hasMany)
  ├─→ Cuentas Financieras (hasMany)
  ├─→ Transacciones (hasMany)
  ├─→ Presupuestos Mensuales (hasMany)
  ├─→ Metas Financieras (hasMany)
  ├─→ Facturas (hasMany)
  ├─→ Lecciones (ProgresoLeccion - hasMany)
  ├─→ Grupos Compartidos (hasMany - creador)
  ├─→ Miembros de Grupos (hasMany)
  └─→ Gastos Compartidos (hasMany - pagador)

TRANSACCIONES
  ├─← Usuario (belongsTo)
  ├─← Cuenta Financiera (belongsTo)
  └─← Categoría (belongsTo)

PRESUPUESTOS MENSUALES
  ├─← Usuario (belongsTo)
  └─→ Detalles por Categoría/Sobres (hasMany)

PRESUPUESTO DETALLE CATEGORÍA
  ├─← Presupuesto (belongsTo)
  └─← Categoría (belongsTo)

METAS FINANCIERAS
  ├─← Usuario (belongsTo)
  └─→ Aportaciones (hasMany)

CATEGORÍAS
  ├─← Usuario (belongsTo)
  ├─→ Transacciones (hasMany)
  └─→ Presupuesto Detalles (hasMany)

MÓDULOS EDUCATIVOS
  └─→ Lecciones (hasMany)

LECCIONES EDUCATIVAS
  ├─← Módulo (belongsTo)
  └─→ Progreso de Lecciones (hasMany)

PROGRESO LECCIONES
  ├─← Usuario (belongsTo)
  └─← Lección (belongsTo)

GRUPOS COMPARTIDOS
  ├─← Usuario (belongsTo - creador)
  ├─→ Miembros (hasMany)
  └─→ Gastos (hasMany)

GASTOS COMPARTIDOS
  ├─← Grupo (belongsTo)
  ├─← Usuario (belongsTo - pagador)
  ├─← Categoría (belongsTo)
  └─→ Participantes (hasMany)

GASTOS COMPARTIDOS PARTICIPANTES
  ├─← Gasto Compartido (belongsTo)
  └─← Usuario (belongsTo)
```

> Nota: La tabla `migrations` es una tabla interna de Laravel que registra qué migraciones se han ejecutado. No se incluye como entidad de negocio en el modelo de datos.

### Estructura de Tablas Principales

#### USUARIOS
| Campo | Tipo | Descripción |
|-------|------|-------------|
| id_usuario | INT PK | Identificador único |
| nombre | VARCHAR(255) | Nombre completo |
| email | VARCHAR(255) UNIQUE | Correo electrónico |
| password_hash | VARCHAR(255) | Contraseña encriptada |
| telefono | VARCHAR(20) | Número telefónico |
| moneda_preferida | VARCHAR(3) | Moneda (USD, EUR, etc.) |
| idioma_preferido | VARCHAR(5) | Idioma (es, en, etc.) |
| estado_cuenta | ENUM | Activa/Bloqueada/Suspendida |
| isadmin | BOOLEAN | Indicador de administrador |
| fecha_registro | DATETIME | Fecha de creación |
| ultimo_acceso | DATETIME | Último login |

#### TRANSACCIONES
| Campo | Tipo | Descripción |
|-------|------|-------------|
| id_transaccion | INT PK | Identificador único |
| id_usuario | INT FK | Referencia a usuario |
| id_cuenta | INT FK | Referencia a cuenta financiera |
| id_categoria | INT FK | Referencia a categoría |
| tipo_movimiento | ENUM | 'ingreso' o 'gasto' |
| titulo | VARCHAR(255) | Título de transacción |
| descripcion | TEXT | Detalles adicionales |
| monto | DECIMAL(12,2) | Monto de la transacción |
| fecha_transaccion | DATE | Fecha del movimiento |
| metodo_pago | VARCHAR(50) | Efectivo, tarjeta, transferencia, etc. |

#### PRESUPUESTOS MENSUALES
| Campo | Tipo | Descripción |
|-------|------|-------------|
| id_presupuesto | INT PK | Identificador único |
| id_usuario | INT FK | Referencia a usuario |
| anio | YEAR | Año del presupuesto |
| mes | MONTH | Mes del presupuesto |
| ingreso_estimado | DECIMAL(12,2) | Ingreso proyectado |
| porcentaje_necesidades | DECIMAL(5,2) | % para necesidades (def: 50) |
| porcentaje_deseos | DECIMAL(5,2) | % para deseos (def: 30) |
| porcentaje_ahorro | DECIMAL(5,2) | % para ahorro (def: 20) |

#### PRESUPUESTO DETALLE CATEGORÍA (SOBRES)
| Campo | Tipo | Descripción |
|-------|------|-------------|
| id_detalle | INT PK | Identificador único |
| id_presupuesto | INT FK | Referencia a presupuesto |
| id_categoria | INT FK | Referencia a categoría |
| tipo_presupuesto | ENUM | 'necesidades', 'deseos', 'ahorro' |
| limite_monto | DECIMAL(12,2) | Límite de gasto asignado |
| monto_gastado | DECIMAL(12,2) | Monto consumido |

#### METAS FINANCIERAS
| Campo | Tipo | Descripción |
|-------|------|-------------|
| id_meta | INT PK | Identificador único |
| id_usuario | INT FK | Referencia a usuario |
| titulo | VARCHAR(255) | Nombre de la meta |
| descripcion | TEXT | Detalles de la meta |
| monto_objetivo | DECIMAL(12,2) | Monto a alcanzar |
| monto_actual | DECIMAL(12,2) | Monto acumulado |
| fecha_inicio | DATE | Inicio de la meta |
| fecha_limite | DATE | Fecha objetivo |
| prioridad | ENUM | 'baja', 'media', 'alta' |
| estado | ENUM | 'activa', 'completada', 'pausada' |

#### FACTURAS
| Campo | Tipo | Descripción |
|-------|------|-------------|
| id_factura | INT PK | Identificador único |
| id_usuario | INT FK | Referencia a usuario |
| proveedor | VARCHAR(255) | Empresa/persona prestadora |
| concepto | VARCHAR(255) | Descripción del servicio |
| descripcion | TEXT | Detalles adicionales |
| monto_total | DECIMAL(12,2) | Monto a pagar |
| fecha_vencimiento | DATE | Fecha de vencimiento |
| fecha_pago | DATE | Fecha de pago realizado |
| estado | ENUM | 'pendiente', 'pagada', 'vencida' |
| frecuencia | ENUM | 'unica', 'mensual', 'anual' |

#### CATEGORÍAS
| Campo | Tipo | Descripción |
|-------|------|-------------|
| id_categoria | INT PK | Identificador único |
| id_usuario | INT FK | Referencia a usuario |
| nombre | VARCHAR(255) | Nombre de categoría |
| descripcion | TEXT | Descripción |
| icono | VARCHAR(50) | Nombre del ícono |
| color | VARCHAR(7) | Color en formato hex (#RRGGBB) |
| tipo | ENUM | 'ingreso' o 'gasto' |

#### MÓDULOS EDUCATIVOS
| Campo | Tipo | Descripción |
|-------|------|-------------|
| id_modulo | INT PK | Identificador único |
| titulo | VARCHAR(255) | Nombre del módulo |
| descripcion | TEXT | Descripción del contenido |
| nivel | ENUM | 'basico', 'intermedio', 'avanzado' |
| duracion_minutos | INT | Duración estimada |

#### LECCIONES EDUCATIVAS
| Campo | Tipo | Descripción |
|-------|------|-------------|
| id_leccion | INT PK | Identificador único |
| id_modulo | INT FK | Referencia a módulo |
| titulo | VARCHAR(255) | Nombre de la lección |
| contenido | LONGTEXT | Contenido HTML de la lección |
| duracion_minutos | INT | Duración estimada |

#### PROGRESO LECCIONES
| Campo | Tipo | Descripción |
|-------|------|-------------|
| id_progreso | INT PK | Identificador único |
| id_usuario | INT FK | Referencia a usuario |
| id_leccion | INT FK | Referencia a lección |
| completada | BOOLEAN | Si está completada |
| fecha_completada | DATETIME | Cuándo se completó |

#### GRUPOS COMPARTIDOS
| Campo | Tipo | Descripción |
|-------|------|-------------|
| id_grupo | INT PK | Identificador único |
| creado_por | INT FK | Usuario creador |
| nombre | VARCHAR(255) | Nombre del grupo |
| descripcion | TEXT | Descripción |
| fecha_creacion | DATETIME | Cuándo se creó |

#### GRUPO MIEMBROS
| Campo | Tipo | Descripción |
|-------|------|-------------|
| id_miembro | INT PK | Identificador único |
| id_grupo | INT FK | Referencia a grupo |
| id_usuario | INT FK | Referencia a usuario miembro |
| rol | ENUM | 'admin', 'miembro' |
| fecha_union | DATETIME | Cuándo se unió |

#### GASTOS COMPARTIDOS
| Campo | Tipo | Descripción |
|-------|------|-------------|
| id_gasto | INT PK | Identificador único |
| id_grupo | INT FK | Referencia a grupo |
| id_usuario_pagador | INT FK | Usuario que pagó |
| id_categoria | INT FK | Referencia a categoría |
| titulo | VARCHAR(255) | Descripción del gasto |
| monto_total | DECIMAL(12,2) | Monto total |
| fecha_gasto | DATE | Fecha del gasto |

#### GASTOS COMPARTIDOS PARTICIPANTES
Tabla de unión entre gastos compartidos y usuarios participantes.

| Campo | Tipo | Descripción |
|-------|------|-------------|
| id | INT PK | Identificador único |
| id_gasto | INT FK | Referencia a gasto |
| id_usuario | INT FK | Usuario participante |
| monto_correspondiente | DECIMAL(12,2) | Monto que le corresponde pagar |

#### CONFIGURACIÓN USUARIO
| Campo | Tipo | Descripción |
|-------|------|-------------|
| id_configuracion | INT PK | Identificador único |
| id_usuario | INT FK | Referencia a usuario |
| notificaciones_email | BOOLEAN | Recibir notificaciones |
| alerta_presupuesto | BOOLEAN | Alerta al exceder presupuesto |
| recordatorio_facturas | BOOLEAN | Recordatorio de facturas |
| recordatorio_metas | BOOLEAN | Recordatorio de metas |

---

## 🎯 MÓDULOS PRINCIPALES

### 1. 📱 Módulo Dashboard

**Propósito:** Panel de control con resumen financiero general

**Servicios:** `DashboardService`

**Funcionalidades:**
- Resumen de ingresos del mes actual
- Resumen de gastos del mes actual
- Cálculo de balance mensual
- Últimas 5 transacciones registradas
- Contador de facturas pendientes
- Contador de metas activas
- Visualización rápida del estado financiero

**Datos Retornados:**
```php
[
    'ingresosMes' => decimal,
    'gastosMes' => decimal,
    'balance' => decimal,
    'ultimasTransacciones' => Collection,
    'facturasPendientes' => int,
    'metasActivas' => int,
]
```

### 2. 💰 Módulo Transacciones

**Propósito:** Gestión de movimientos financieros (ingresos y gastos)

**Controlador:** `TransaccionController`  
**Servicio:** `TransaccionService`

**CRUD Completo:**
- **CREATE:** Agregar nuevas transacciones
- **READ:** Listar con búsqueda y filtros
- **UPDATE:** Editar transacciones existentes
- **DELETE:** Eliminar transacciones

**Funcionalidades Específicas:**
- Filtrado por búsqueda (título, descripción, categoría)
- Filtrado por tipo (ingreso/gasto)
- Cálculo automático de totales
- Recalcular sobres relacionados automáticamente
- Validación de montos y fechas
- Asociación automática con cuenta y categoría

**Búsqueda y Filtros:**
```php
obtenerDatosIndex($idUsuario, $busqueda, $tipo)
// Retorna: transacciones, totalIngresos, totalGastos, totalTransacciones
```

**Operación Importante: Recalcular Sobres**
Cuando se crea o edita una transacción:
1. Se valida la categoría y monto
2. Se busca el sobre (PresupuestoDetalleCategoria) relacionado
3. Se recalcula el monto_gastado del sobre
4. Se actualiza el estado del sobre (dentro/fuera de presupuesto)

### 3. 📊 Módulo Presupuestos

**Propósito:** Creación y gestión de presupuestos mensuales con sistema de sobres

**Controlador:** `PresupuestoController`  
**Servicio:** `PresupuestoService`

**Características Principales:**

#### Sistema de Sobres (Envelope Budgeting)
- Distribución automática según regla 50/30/20
- Personalización de porcentajes por usuario
- Creación manual de sobres por categoría
- Monitoreo de gasto vs. límite

#### CRUD Completo de Presupuestos
- Crear presupuesto mensual
- Seleccionar presupuesto activo
- Editar porcentajes y montos
- Eliminar presupuestos antiguos

#### Funcionalidades de Sobres
- Crear sobres personalizados
- Asignar límites de gasto
- Editar límites existentes
- Eliminar sobres
- Visualizar consumo por sobre

**Lógica de Distribución:**
```php
// Dado un ingreso estimado, se distribuye:
necesidades = ingreso * porcentaje_necesidades / 100
deseos = ingreso * porcentaje_deseos / 100
ahorro = ingreso * porcentaje_ahorro / 100
```

**Cálculos Automáticos:**
```php
monto_gastado = suma de transacciones por categoría en el mes
disponible = limite_monto - monto_gastado
estado = disponible > 0 ? 'Ok' : 'Excedido'
```

### 4. 🎯 Módulo Metas Financieras

**Propósito:** Gestión de objetivos financieros a corto, medio y largo plazo

**Controlador:** `MetaFinancieraController`  
**Servicio:** `MetaFinancieraService`

**CRUD Completo:**
- Crear metas con título, descripción, monto objetivo y plazo
- Visualizar metas activas/completadas
- Editar parámetros de metas
- Eliminar metas

**Estados de Meta:**
- `activa` - En progreso
- `completada` - Meta alcanzada
- `pausada` - Suspendida temporalmente

**Prioridades:**
- `baja` - Secundaria
- `media` - Normal
- `alta` - Crítica/Urgente

**Funcionalidades:**
- Registrar aportaciones a metas
- Cálculo automático de progreso (%)
- Estimación de fecha de completitud
- Visualización de tendencias

**Progreso Automático:**
```php
progreso_porcentaje = (monto_actual / monto_objetivo) * 100
dias_restantes = fecha_limite - fecha_hoy
dias_utilizados = fecha_hoy - fecha_inicio
```

### 5. 📄 Módulo Facturas

**Propósito:** Gestión de pagos recurrentes y facturas

**Controlador:** `FacturaController`

**CRUD Completo:**
- Crear facturas (proveedor, monto, vencimiento)
- Listar facturas con filtros
- Editar información de facturas
- Eliminar facturas
- Marcar como pagada (PATCH)

**Estados de Factura:**
- `pendiente` - Aún no se paga
- `pagada` - Ya se realizó el pago
- `vencida` - Pasó la fecha de vencimiento sin pagar

**Frecuencias:**
- `unica` - Una sola vez
- `mensual` - Cada mes
- `anual` - Cada año

**Operaciones Especiales:**
- Marcar factura como pagada: `PATCH /facturas/{id}/pagar`
- Cálculo de días para vencimiento
- Historial de pagos

### 6. 🎓 Módulo Educación Financiera

**Propósito:** Plataforma de aprendizaje sobre finanzas personales

**Controladores:**
- `EducacionController` - Vista general
- `ModuloEducativoController` - Gestión de módulos (admin)
- `LeccionEducativaController` - Gestión de lecciones

**Modelos Relacionados:**
- `ModuloEducativo`
- `LeccionEducativa`
- `ProgresoLeccion`

**Estructura Jerárquica:**
```
Módulo Educativo (ej: "Presupuesto Básico")
  ├─ Nivel: básico, intermedio, avanzado
  ├─ Duración estimada: minutos
  └─→ Lecciones
      ├─ Lección 1: "¿Qué es un presupuesto?"
      ├─ Lección 2: "Método 50/30/20"
      └─ Progreso de Leccion (por usuario)
         ├─ Completada: true/false
         └─ Fecha completada
```

**Funcionalidades Usuario:**
- Ver módulos disponibles
- Acceder a lecciones
- Marcar lecciones como completadas
- Ver progreso de aprendizaje

**Funcionalidades Admin:**
- Crear módulos educativos
- Crear lecciones con contenido HTML
- Editar módulos y lecciones
- Eliminar módulos/lecciones
- Especificar duración y nivel

### 7. 📅 Módulo Calendario Financiero

**Propósito:** Visualización de eventos financieros próximos

**Controlador:** `CalendarioController`  
**Servicio:** `CalendarioService`

**Eventos Mostrados:**
- Fechas límite de metas financieras
- Vencimiento de facturas
- Hitos financieros personalizados

**Funcionalidades:**
- Listado ordenado por fecha
- Categorización por tipo de evento
- Alertas de proximidad
- Integración con calendario del navegador

### 8. 📈 Módulo Reportes

**Propósito:** Análisis y visualización de datos financieros históricos

**Controlador:** `ReporteController`  
**Servicio:** `ReporteService`

**Tipos de Reportes:**

#### Reporte Mensual
- Ingresos totales
- Gastos totales
- Balance neto
- Desglose por categoría

#### Reporte Anual
- Comparativa mes a mes
- Tendencias de gasto
- Picos de ingreso/egreso
- Promedio mensual

#### Análisis por Categoría
- Gasto total por categoría
- Categoría con mayor gasto
- Categoría con mayor ingreso
- Variación mes a mes

**Datos Generados:**
```php
[
    'resumenMensual' => [
        'mes' => int,
        'ingresos' => decimal,
        'gastos' => decimal,
        'balance' => decimal,
    ],
    'gastosPorCategoria' => [
        'categoria' => decimal,
        ...
    ],
    'aniosDisponibles' => [2024, 2025, 2026],
    'maximo' => [mes, cantidad],
    'promedio' => decimal,
]
```

### 9. 👥 Módulo Gastos Compartidos

**Propósito:** Gestión de gastos entre grupos de personas

**Controlador:** `CompartidoController`

**Modelos Relacionados:**
- `GrupoCompartido`
- `GrupoMiembro`
- `GastoCompartido`
- `GastoCompartidoParticipante`

**Funcionalidades por Rol:**

#### Administrador de Grupo
- Crear grupos
- Invitar/agregar miembros
- Eliminar miembros
- Registrar gastos
- Ver resumen de deudas

#### Miembro de Grupo
- Ver miembros del grupo
- Registrar gastos personales
- Ver desglose de gastos
- Visualizar deudas/créditos

**Flujo Operativo:**

1. **Crear Grupo**: Usuario A crea grupo "Viaje Madrid"
2. **Agregar Miembros**: Invita a B, C, D
3. **Registrar Gasto**: Usuario A paga $100 de hotel (divide entre 4)
4. **Calcular Deudas**: 
   - A pagó $100, le corresponde $25
   - B le debe $25, C le debe $25, D le debe $25

**Cálculo de Distribución:**
```php
monto_por_participante = monto_total / cantidad_participantes
deuda_por_persona = monto_por_participante - (monto_pagado_por_persona)
```

### 10. ⚙️ Módulo Configuración y Perfil

**Propósito:** Gestión de preferencias y datos de usuario

**Controladores:**
- `ConfiguracionController`
- `PerfilController`

**Funcionalidades de Perfil:**
- Editar nombre, email, teléfono
- Cambiar contraseña
- Ver información de cuenta

**Configuraciones Generales:**
- Moneda preferida
- Idioma preferido
- Notificaciones (email)
- Alertas de presupuesto
- Recordatorios de facturas
- Recordatorios de metas

**Operaciones Especiales:**
- Exportar datos financieros
- Eliminar cuenta permanentemente

### 11. 📋 Módulo Categorías

**Propósito:** Creación y gestión de categorías personalizadas

**Controlador:** `CategoriaController`

**Funcionalidades:**
- Crear categorías (ingresos/gastos)
- Asignar íconos y colores
- Editar categorías existentes
- Eliminar categorías
- Uso en transacciones y presupuestos

**Estructura de Categoría:**
```php
[
    'nombre' => 'Alimentación',
    'tipo' => 'gasto',
    'icono' => 'shopping-cart',
    'color' => '#FF6B6B',
    'descripcion' => 'Gastos en comida y bebidas',
]
```

---

## 🔧 SERVICIOS

### TransaccionService

**Responsabilidades:**
- Obtener listados con búsqueda y filtros
- Recalcular sobres cuando cambian transacciones
- Cálculos de totales

**Métodos Principales:**
```php
obtenerDatosIndex($idUsuario, $busqueda = null, $tipo = null)
// Retorna: transacciones, totalIngresos, totalGastos, totalTransacciones

recalcularSobresRelacionados($transaccion)
// Actualiza los montos_gastados de sobres relacionados

recalcularSobresPorDatosAnteriores($usuarioId, $categoriaId, $fecha)
// Ajusta sobres si cambió información de transacción existente
```

### PresupuestoService

**Responsabilidades:**
- Gestión de presupuestos mensuales
- Cálculos de distribución 50/30/20
- Agregación de gastos por tipo

**Métodos Principales:**
```php
obtenerDatosIndex($usuarioId, $presupuestoActivoId)
// Retorna presupuestos con cálculos de gasto vs. presupuesto

obtenerValoresPorDefecto()
// Retorna [50, 30, 20] para la regla 50/30/20

calcularMontoPorcentaje($monto, $porcentaje)
// Calcula porcentaje de un monto

sumarPorTipo($detalles, $tipo, $campo)
// Suma gastos por tipo (necesidades/deseos/ahorro)
```

### DashboardService

**Responsabilidades:**
- Cálculo de resumen financiero mensual
- Obtención de datos para el panel principal

**Métodos Principales:**
```php
obtenerResumen($idUsuario)
// Retorna: ingresosMes, gastosMes, balance, 
// ultimasTransacciones, facturasPendientes, metasActivas
```

### ReporteService

**Responsabilidades:**
- Análisis histórico de datos financieros
- Generación de reportes y estadísticas

**Métodos Principales:**
```php
obtenerDatosReportes($idUsuario, $anio = null, $mes = null)
// Retorna datos completos para reportes

obtenerResumenMensual($idUsuario, $anio)
// Resumen mes a mes por año

obtenerGastosPorCategoria($idUsuario, $anio, $mes)
// Desglose de gastos por categoría

obtenerAniosDisponibles($idUsuario)
// Años con transacciones registradas
```

### CalendarioService

**Responsabilidades:**
- Obtención de eventos financieros próximos

**Métodos Principales:**
```php
obtenerEventosPendientes($idUsuario)
// Retorna metas próximas a vencer y facturas por vencer
```

### ConfiguracionService

**Responsabilidades:**
- Gestión de preferencias de usuario

**Métodos Principales:**
```php
guardarConfiguracion($idUsuario, $datos)
obtenerConfiguracion($idUsuario)
```

### MetaFinancieraService

**Responsabilidades:**
- Operaciones de metas financieras

**Métodos Principales:**
```php
calcularProgreso($metaId)
// Calcula porcentaje de progreso

estimarFechaCompletitud($metaId)
// Estima cuándo se completará
```

---

## 🛣️ RUTAS Y ENDPOINTS

### Estructura de Rutas

Todas las rutas protegidas requieren autenticación mediante middleware `auth`.

### Rutas de Autenticación
```
GET  /                          → Redirige a dashboard o login
GET  /login                     → Formulario de login
POST /login                     → Procesar login
GET  /register                  → Formulario de registro
POST /register                  → Procesar registro
POST /logout                    → Cerrar sesión
GET  /password-reset            → Formulario de recuperación
```

### Rutas de Usuario Autenticado
```
GET  /profile                   → PerfilController@edit
PUT  /profile                   → PerfilController@update
PUT  /profile/password          → PerfilController@updatePassword
GET  /dashboard                 → PanelController@index
```

### Rutas de Transacciones
```
GET    /transacciones           → TransaccionController@index (listar)
GET    /transacciones/create    → TransaccionController@create (form)
POST   /transacciones           → TransaccionController@store (guardar)
GET    /transacciones/{id}/edit → TransaccionController@edit (form)
PUT    /transacciones/{id}      → TransaccionController@update (actualizar)
DELETE /transacciones/{id}      → TransaccionController@destroy (eliminar)
```

### Rutas de Presupuestos
```
GET    /presupuestos            → PresupuestoController@index
GET    /presupuestos/create     → PresupuestoController@create
POST   /presupuestos            → PresupuestoController@store
GET    /presupuestos/{id}/edit  → PresupuestoController@edit
PUT    /presupuestos/{id}       → PresupuestoController@update
DELETE /presupuestos/{id}       → PresupuestoController@destroy
POST   /presupuestos/select     → PresupuestoController@select (activar)
```

### Rutas de Sobres (PresupuestoDetalleCategoria)
```
GET    /presupuestos/{id}/sobres/create     → Crear sobre
POST   /presupuestos/{id}/sobres            → Guardar sobre
GET    /sobres/{id}/edit                    → Editar sobre
PUT    /sobres/{id}                         → Actualizar sobre
DELETE /sobres/{id}                         → Eliminar sobre
```

### Rutas de Metas Financieras
```
GET    /metas                   → MetaFinancieraController@index
GET    /metas/create            → MetaFinancieraController@create
POST   /metas                   → MetaFinancieraController@store
GET    /metas/{id}/edit         → MetaFinancieraController@edit
PUT    /metas/{id}              → MetaFinancieraController@update
DELETE /metas/{id}              → MetaFinancieraController@destroy
```

### Rutas de Facturas
```
GET    /facturas                → FacturaController@index
GET    /facturas/create         → FacturaController@create
POST   /facturas                → FacturaController@store
GET    /facturas/{id}/edit      → FacturaController@edit
PUT    /facturas/{id}           → FacturaController@update
DELETE /facturas/{id}           → FacturaController@destroy
PATCH  /facturas/{id}/pagar     → FacturaController@marcarPagada
```

### Rutas de Educación Financiera
```
GET    /educacion               → EducacionController@index
POST   /educacion/completar/{id} → EducacionController@completar

// Módulos (admin only)
GET    /modulos-educativos/create         → ModuloEducativoController@create
POST   /modulos-educativos                → ModuloEducativoController@store
GET    /modulos-educativos/{id}/edit      → ModuloEducativoController@edit
PUT    /modulos-educativos/{id}           → ModuloEducativoController@update
DELETE /modulos-educativos/{id}           → ModuloEducativoController@destroy

// Lecciones
GET    /modulos-educativos/{id}/lecciones → LeccionEducativaController@index
GET    /modulos-educativos/{id}/lecciones/create → LeccionEducativaController@create (admin)
POST   /modulos-educativos/{id}/lecciones → LeccionEducativaController@store (admin)
GET    /modulos-educativos/{id}/lecciones/{id} → LeccionEducativaController@show
GET    /modulos-educativos/{id}/lecciones/{id}/edit → LeccionEducativaController@edit (admin)
PUT    /modulos-educativos/{id}/lecciones/{id} → LeccionEducativaController@update (admin)
DELETE /modulos-educativos/{id}/lecciones/{id} → LeccionEducativaController@destroy (admin)
```

### Rutas de Calendario
```
GET  /calendario                → CalendarioController@index
```

### Rutas de Reportes
```
GET  /reportes                  → ReporteController@index
```

### Rutas de Categorías
```
GET    /categorias              → CategoriaController@index
GET    /categorias/create       → CategoriaController@create
POST   /categorias              → CategoriaController@store
GET    /categorias/{id}/edit    → CategoriaController@edit
PUT    /categorias/{id}         → CategoriaController@update
DELETE /categorias/{id}         → CategoriaController@destroy
```

### Rutas de Gastos Compartidos
```
GET    /compartido              → CompartidoController@index

// Grupos
POST   /compartido/grupo        → CompartidoController@storeGrupo
PUT    /compartido/grupo/{id}   → CompartidoController@updateGrupo

// Miembros
POST   /compartido/miembro      → CompartidoController@storeMiembro
PUT    /compartido/miembro/{id} → CompartidoController@updateMiembro
DELETE /compartido/miembro/{id} → CompartidoController@destroyMiembro

// Gastos
GET    /compartido/gastos/create → CompartidoController@createGasto
POST   /compartido/gasto        → CompartidoController@storeGasto
PUT    /compartido/gasto/{id}   → CompartidoController@updateGasto
DELETE /compartido/gasto/{id}   → CompartidoController@destroyGasto
```

### Rutas de Configuración
```
GET    /configuracion           → ConfiguracionController@index
PUT    /configuracion/perfil    → ConfiguracionController@updatePerfil
PUT    /configuracion/moneda    → ConfiguracionController@updateMoneda
PUT    /configuracion/notificaciones → ConfiguracionController@updateNotificaciones
PUT    /configuracion/password  → ConfiguracionController@updatePassword
GET    /configuracion/exportar-datos → ConfiguracionController@exportarDatos
DELETE /configuracion/eliminar-cuenta → ConfiguracionController@destroyCuenta
```

---

## 📁 ESTRUCTURA DE DIRECTORIOS

```
kwaly/
├── app/
│   ├── Helpers/
│   │   ├── CalendarioHelper.php
│   │   ├── ConsejoFinancieroHelper.php
│   │   ├── FormatoHelper.php
│   │   ├── MensajeHelper.php
│   │   └── PresupuestoHelper.php
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Autenticacion/
│   │   │   ├── CalendarioController.php
│   │   │   ├── CategoriaController.php
│   │   │   ├── CompartidoController.php
│   │   │   ├── ConfiguracionController.php
│   │   │   ├── EducacionController.php
│   │   │   ├── FacturaController.php
│   │   │   ├── LeccionEducativaController.php
│   │   │   ├── MetaFinancieraController.php
│   │   │   ├── ModuloEducativoController.php
│   │   │   ├── PanelController.php
│   │   │   ├── PerfilController.php
│   │   │   ├── PresupuestoController.php
│   │   │   ├── PresupuestoDetalleCategoriaController.php
│   │   │   ├── ReporteController.php
│   │   │   └── TransaccionController.php
│   │   ├── Middleware/
│   │   ├── Requests/ (Form Request Validations)
│   ├── Models/
│   │   ├── AportacionMeta.php
│   │   ├── Categoria.php
│   │   ├── ConfiguracionUsuario.php
│   │   ├── CuentaFinanciera.php
│   │   ├── Factura.php
│   │   ├── GastoCompartido.php
│   │   ├── GastoCompartidoParticipante.php
│   │   ├── GrupoCompartido.php
│   │   ├── GrupoMiembro.php
│   │   ├── LeccionEducativa.php
│   │   ├── MetaFinanciera.php
│   │   ├── ModuloEducativo.php
│   │   ├── PresupuestoDetalleCategoria.php
│   │   ├── PresupuestoMensual.php
│   │   ├── ProgresoLeccion.php
│   │   ├── Transaccion.php
│   │   └── Usuario.php
│   ├── Providers/
│   │   └── AppServiceProvider.php
│   ├── Services/
│   │   ├── CalendarioService.php
│   │   ├── ConfiguracionService.php
│   │   ├── DashboardService.php
│   │   ├── MetaFinancieraService.php
│   │   ├── PresupuestoService.php
│   │   ├── ReporteService.php
│   │   └── TransaccionService.php
│   └── View/
│       └── Components/
├── bootstrap/
│   ├── app.php
│   ├── providers.php
│   └── cache/
├── config/
│   ├── app.php
│   ├── auth.php
│   ├── cache.php
│   ├── database.php
│   ├── filesystems.php
│   ├── logging.php
│   ├── mail.php
│   ├── queue.php
│   ├── services.php
│   └── session.php
├── database/
│   ├── factories/
│   │   └── UsuarioFactory.php
│   ├── migrations/
│   │   ├── 0001_01_01_000000_crear_usuarios_tabla.php
│   │   ├── 2026_05_10_000001_agregar_isadmin_a_usuarios.php
│   │   ├── 2026_05_10_000002_crear_tablas_dominio.php
│   │   └── ... (otras migraciones)
│   └── seeders/
│       └── DatabaseSeeder.php
├── lang/
│   └── es/
│       ├── auth.php
│       ├── configuracion.php
│       └── ... (otros idiomas)
├── public/
│   ├── index.php
│   ├── robots.txt
│   └── build/ (Assets compilados)
├── resources/
│   ├── css/
│   ├── js/
│   └── views/
├── routes/
│   ├── autenticacion.php
│   ├── console.php
│   └── web.php
├── storage/
│   ├── app/
│   ├── framework/
│   └── logs/
├── tests/
│   ├── TestCase.php
│   ├── Feature/
│   └── Unit/
├── vendor/ (Dependencias de Composer)
├── .env (Configuración local)
├── .env.example (Plantilla de configuración)
├── artisan (CLI de Laravel)
├── composer.json
├── composer.lock
├── package.json
├── package-lock.json
├── vite.config.js
├── tailwind.config.js
├── postcss.config.js
├── phpunit.xml
└── README.md
```

---

## 🛠️ STACK TECNOLÓGICO

### Backend
- **Framework:** Laravel 12 (PHP Framework)
- **Lenguaje:** PHP 8.2+
- **Base de Datos:** MySQL/MariaDB
- **ORM:** Eloquent (incluido en Laravel)
- **Validación:** Form Requests de Laravel

### Frontend
- **Template Engine:** Blade (Laravel)
- **CSS Framework:** Tailwind CSS
- **UI Components:** DaisyUI
- **JavaScript Framework:** Alpine.js
- **Build Tool:** Vite
- **HTTP Client:** Axios

### Herramientas de Desarrollo
- **Gestor de Dependencias PHP:** Composer
- **Gestor de Dependencias JS:** NPM
- **Testing:** PHPUnit
- **Linting:** Laravel Pint
- **Environment Management:** Dotenv

### Librerías Importantes
- **Gráficos:** Chart.js
- **Notificaciones:** SweetAlert2
- **Post-processing CSS:** PostCSS

---

## 📦 GUÍA DE INSTALACIÓN

### Prerrequisitos
- PHP 8.2 o superior
- Composer instalado
- Node.js y npm instalados
- MySQL o MariaDB ejecutándose
- Navegador web moderno

### Pasos de Instalación

#### 1. Clonar o descargar el proyecto
```bash
cd c:\Users\k0343\Desktop\kwaly
```

#### 2. Crear archivo .env
```bash
# Copiar archivo de ejemplo
cp .env.example .env

# O crear manualmente con:
APP_NAME=Kwaly
APP_ENV=local
APP_DEBUG=true
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=kwaly
DB_USERNAME=root
DB_PASSWORD=
```

#### 3. Instalar dependencias PHP
```bash
composer install
```

#### 4. Generar clave de aplicación
```bash
php artisan key:generate
```

#### 5. Crear base de datos
```bash
# Mediante phpMyAdmin:
# 1. Abrir http://localhost/phpmyadmin
# 2. Crear nueva base de datos llamada 'kwaly'
# 3. Charset: utf8mb4, Colation: utf8mb4_unicode_ci
```

#### 6. Ejecutar migraciones
```bash
php artisan migrate --seed
```

#### 7. Instalar dependencias JavaScript
```bash
npm install
```

#### 8. Compilar assets
```bash
npm run build
# Para desarrollo con hot-reload:
npm run dev
```

#### 9. Iniciar servidor
```bash
# Terminal 1: Servidor Laravel
php artisan serve

# Terminal 2: Compilación de assets (opcional, si usas npm run dev)
npm run dev
```

#### 10. Acceder a la aplicación
```
URL: http://127.0.0.1:8000
```

### Ejecutar Tests
```bash
php artisan test
```

### Comando de Setup Automático
```bash
composer setup
```

---

## 🔄 FLUJOS PRINCIPALES

### Flujo 1: Registro de Usuario

```
1. Usuario accede a /register
2. Completa formulario (nombre, email, contraseña)
3. Sistema valida datos
4. Se crea nuevo usuario en tabla 'usuarios'
5. Se crea ConfiguracionUsuario con valores por defecto
6. Se redirige a login
7. Usuario inicia sesión
8. Se redirige a dashboard
```

### Flujo 2: Creación de Transacción

```
1. Usuario accede a /transacciones/create
2. Completa formulario:
   - Tipo (ingreso/gasto)
   - Monto
   - Categoría
   - Cuenta financiera
   - Fecha
   - Descripción
3. Sistema valida datos
4. Se guarda transacción
5. TransaccionService.recalcularSobresRelacionados() se ejecuta:
   a. Busca PresupuestoDetalleCategoria relacionado
   b. Suma todas las transacciones de esa categoría en el mes
   c. Actualiza monto_gastado
   d. Compara con limite_monto
6. Se redirige a listado de transacciones
```

### Flujo 3: Creación de Presupuesto Mensual

```
1. Usuario accede a /presupuestos/create
2. Completa formulario:
   - Mes y año
   - Ingreso estimado
   - Porcentajes (opcional, usa 50/30/20 por defecto)
3. Sistema valida datos
4. Se crea PresupuestoMensual
5. Sistema calcula montos por tipo:
   - necesidades = ingreso * 50%
   - deseos = ingreso * 30%
   - ahorro = ingreso * 20%
6. Se crean PresupuestoDetalleCategoria automáticos para categorías predefinidas
7. Usuario puede agregar sobres personalizados
8. Sistema guarda presupuesto en sesión como presupuesto activo
```

### Flujo 4: Creación de Meta Financiera

```
1. Usuario accede a /metas/create
2. Completa formulario:
   - Título (ej: "Viaje a Europa")
   - Descripción
   - Monto objetivo
   - Fecha límite
   - Prioridad
3. Sistema valida datos
4. Se guarda MetaFinanciera con:
   - estado: 'activa'
   - monto_actual: 0
   - fecha_inicio: fecha actual
5. Usuario puede registrar aportaciones
6. Sistema recalcula:
   - Progreso (%)
   - Días restantes
   - Estimación de completitud
```

### Flujo 5: Crear Grupo de Gasto Compartido

```
1. Usuario A accede a /compartido
2. Crea grupo "Viaje Amigos"
3. Sistema crea GrupoCompartido con creado_por = Usuario A
4. Usuario A agrega miembros B, C, D
5. Se crean GrupoMiembro con rol 'miembro'
6. Usuario A registra gasto: Hotel $100
7. Sistema crea GastoCompartido
8. Sistema crea 4 GastoCompartidoParticipante:
   - A: monto = 25 (pagó 100, corresponde 25, le deben 75)
   - B: monto = 25 (corresponde pagar 25)
   - C: monto = 25 (corresponde pagar 25)
   - D: monto = 25 (corresponde pagar 25)
9. Sistema calcula deudas/créditos por usuario
```

### Flujo 6: Análisis de Reportes

```
1. Usuario accede a /reportes
2. Selecciona año y mes
3. ReporteService.obtenerDatosReportes() se ejecuta:
   a. obtenerResumenMensual(año, mes)
   b. obtenerGastosPorCategoria(año, mes)
   c. obtenerAniosDisponibles()
4. Calcula:
   - Ingresos totales
   - Gastos totales
   - Balance neto
   - Desglose por categoría
   - Máximo ingreso/gasto
   - Promedio mensual
5. Genera gráficos con Chart.js
6. Muestra comparativas año a año
```

### Flujo 7: Marcado de Factura como Pagada

```
1. Usuario ve lista de facturas en /facturas
2. Factura muestra estado 'pendiente'
3. Usuario hace clic en "Marcar como pagada"
4. Se envía PATCH a /facturas/{id}/pagar
5. FacturaController.marcarPagada() se ejecuta:
   a. Busca factura
   b. Establece estado = 'pagada'
   c. Registra fecha_pago = fecha actual
   d. Si es recurrente (mensual/anual), crea siguiente
6. Se actualiza lista de facturas
7. Desaparece de "Facturas Pendientes" en dashboard
```

### Flujo 8: Completar Lección Educativa

```
1. Usuario accede a /educacion
2. Visualiza módulos educativos
3. Entra a módulo "Presupuesto Básico"
4. Ve listado de lecciones
5. Hace clic en "Lección 1: ¿Qué es un presupuesto?"
6. Lee contenido HTML
7. Hace clic en "Marcar como completada"
8. Se envía POST a /educacion/completar/1
9. EducacionController.completar() se ejecuta:
   a. Busca o crea ProgresoLeccion
   b. Establece completada = true
   c. Registra fecha_completada
10. Se actualiza progreso del usuario
11. Se muestra siguiente lección
```

---

## 📊 DIAGRAMAS Y EJEMPLOS

### Ejemplo: Ciclo de Vida de una Transacción

```
┌─────────────────────────────────────────────────────────────┐
│ Usuario crea transacción: Compra de comida $30             │
└─────────────────────────────────────────────────────────────┘
                              ↓
┌─────────────────────────────────────────────────────────────┐
│ TransaccionController@store recibe datos                   │
└─────────────────────────────────────────────────────────────┘
                              ↓
┌─────────────────────────────────────────────────────────────┐
│ StoreTransaccionRequest valida:                            │
│ - Monto > 0 ✓                                              │
│ - Categoría existe ✓                                       │
│ - Fecha válida ✓                                           │
└─────────────────────────────────────────────────────────────┘
                              ↓
┌─────────────────────────────────────────────────────────────┐
│ Se guarda en tabla 'transacciones'                         │
│ id_transaccion: 456                                         │
│ id_usuario: 1                                               │
│ id_categoria: 5 (Alimentación)                              │
│ monto: 30.00                                                │
│ tipo_movimiento: gasto                                      │
└─────────────────────────────────────────────────────────────┘
                              ↓
┌─────────────────────────────────────────────────────────────┐
│ TransaccionService::recalcularSobresRelacionados()        │
│ ejecuta automáticamente                                    │
└─────────────────────────────────────────────────────────────┘
                              ↓
┌─────────────────────────────────────────────────────────────┐
│ Busca PresupuestoDetalleCategoria para:                   │
│ - Categoría: Alimentación (5)                              │
│ - Presupuesto: Enero 2025 (activo)                         │
│ - Resultado: id_detalle = 78                               │
└─────────────────────────────────────────────────────────────┘
                              ↓
┌─────────────────────────────────────────────────────────────┐
│ Suma todas las transacciones de Alimentación en Enero 2025:│
│ - Compra pan: $12                                          │
│ - Compra leche: $8                                         │
│ - Compra comida (nueva): $30                               │
│ Total: $50                                                 │
└─────────────────────────────────────────────────────────────┘
                              ↓
┌─────────────────────────────────────────────────────────────┐
│ Actualiza PresupuestoDetalleCategoria (id = 78):          │
│ monto_gastado = 50.00                                      │
│ limite_monto = 150.00                                      │
│ disponible = 100.00 ✓ (dentro del presupuesto)            │
└─────────────────────────────────────────────────────────────┘
                              ↓
┌─────────────────────────────────────────────────────────────┐
│ Usuario ve actualización:                                  │
│ - Dashboard: gastos de enero aumentan a $XXX               │
│ - Presupuestos: Sobre Alimentación muestra $50/$150       │
│ - Transacciones: nueva transacción listada                 │
└─────────────────────────────────────────────────────────────┘
```

### Ejemplo: Distribución de Gastos Compartidos

```
ESCENARIO: Viaje compartido entre 4 personas

┌─────────────────────────────────────────────────────────────┐
│ Grupo "Viaje Madrid"                                        │
│ Miembros: Alice, Bob, Charlie, Diana                        │
└─────────────────────────────────────────────────────────────┘

TRANSACCIÓN 1 - Hotel
┌─────────────────────────────────────────────────────────────┐
│ Alice paga: $400 por 4 noches                              │
│ Corresponde por persona: $100                               │
├─────────────────────────────────────────────────────────────┤
│ Alice:    pagó $400, corresponde $100  → Saldo: +$300     │
│ Bob:      pagó $0,    corresponde $100 → Saldo: -$100     │
│ Charlie:  pagó $0,    corresponde $100 → Saldo: -$100     │
│ Diana:    pagó $0,    corresponde $100 → Saldo: -$100     │
└─────────────────────────────────────────────────────────────┘

TRANSACCIÓN 2 - Comidas
┌─────────────────────────────────────────────────────────────┐
│ Bob paga: $200 comidas                                      │
│ Corresponde por persona: $50                                │
├─────────────────────────────────────────────────────────────┤
│ Bob:     pagó $200, corresponde $50  → Nuevo saldo: -$50  │
│ Alice:   pagó $0,   corresponde $50  → Nuevo saldo: -$50   │
│ Charlie: pagó $0,   corresponde $50  → Nuevo saldo: -$150  │
│ Diana:   pagó $0,   corresponde $50  → Nuevo saldo: -$150  │
└─────────────────────────────────────────────────────────────┘

RESUMEN FINAL DE DEUDAS
┌─────────────────────────────────────────────────────────────┐
│ Alice    (creador): debe recibir $250                       │
│ Bob              : debe pagar $50                           │
│ Charlie          : debe pagar $150                          │
│ Diana            : debe pagar $150                          │
│ TOTAL: $350 balance correcto (350 + 50 + 150 + 150 = 600) │
└─────────────────────────────────────────────────────────────┘

RECOMENDACIONES
┌─────────────────────────────────────────────────────────────┐
│ 1. Charlie paga $150 a Alice                                │
│ 2. Diana paga $150 a Alice                                  │
│ 3. Bob paga $50 a Alice                                     │
│ Total que recibe Alice: $350 ✓                              │
└─────────────────────────────────────────────────────────────┘
```

---

Este documento proporciona una documentación técnica completa de la aplicación Kwaly, detallando su arquitectura, funcionalidades, estructura de datos, y guías de uso. Puedes utilizarlo como base para presentación de proyecto, documentación de código, o como referencia para desarrollo futuro.

