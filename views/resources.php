<?php
$title = $title ?? 'Recursos - NDA';
ob_start();
?>

<div class="resources-page">
    <div class="wrap" style="padding-top: 80px; padding-bottom: 60px;">

        <!-- Encabezado -->
        <div style="text-align: center; margin-bottom: 40px;">
            <h1 style="font-size: 2.5rem; font-weight: 900; background: linear-gradient(135deg, #f97316, #ff5500); -webkit-background-clip: text; -webkit-text-fill-color: transparent; display: inline-block;">
                 Guías y Recursos Educativos
            </h1>
            <p style="color: var(--text2); font-size: 1.1rem; margin-top: 10px;">
                Materiales informativos para la preparación ante desastres naturales
            </p>
        </div>

        <!-- Filtros por categoría -->
        <div style="display: flex; gap: 10px; flex-wrap: wrap; justify-content: center; margin-bottom: 30px;">
            <button class="filter-btn active" data-filter="all" style="background: #f97316; color: #fff; border: none; padding: 8px 20px; border-radius: 50px; font-size: 0.85rem; cursor: pointer; transition: all 0.2s;">Todos</button>
            <button class="filter-btn" data-filter="evacuacion" style="background: var(--card2); color: var(--text1); border: 1px solid var(--border); padding: 8px 20px; border-radius: 50px; font-size: 0.85rem; cursor: pointer; transition: all 0.2s;"> Evacuación</button>
            <button class="filter-btn" data-filter="mochila" style="background: var(--card2); color: var(--text1); border: 1px solid var(--border); padding: 8px 20px; border-radius: 50px; font-size: 0.85rem; cursor: pointer; transition: all 0.2s;"> Mochila</button>
            <button class="filter-btn" data-filter="plan" style="background: var(--card2); color: var(--text1); border: 1px solid var(--border); padding: 8px 20px; border-radius: 50px; font-size: 0.85rem; cursor: pointer; transition: all 0.2s;"> Plan Familiar</button>
            <button class="filter-btn" data-filter="sismo" style="background: var(--card2); color: var(--text1); border: 1px solid var(--border); padding: 8px 20px; border-radius: 50px; font-size: 0.85rem; cursor: pointer; transition: all 0.2s;"> Sismos</button>
            <button class="filter-btn" data-filter="lluvias" style="background: var(--card2); color: var(--text1); border: 1px solid var(--border); padding: 8px 20px; border-radius: 50px; font-size: 0.85rem; cursor: pointer; transition: all 0.2s;"> Lluvias</button>
        </div>

        <!-- Grid de PDFs -->
        <div class="resources-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 24px;">

            <!--   EVACUACIÓN ESCOLAR   -->
            <div class="resource-card" data-category="evacuacion" style="background: var(--card); border: 1px solid var(--border); border-radius: 16px; padding: 24px; transition: transform 0.2s, box-shadow 0.2s;">
                <div style="display: flex; align-items: center; gap: 14px; margin-bottom: 12px;">
                    <div style="font-size: 2.5rem;"></div>
                    <div>
                        <h3 style="font-size: 1rem; font-weight: 700; color: var(--text1); margin: 0;">Evacuación Escolar</h3>
                        <span style="font-size: 0.75rem; color: var(--text3);">PDF · 1.8 MB</span>
                    </div>
                </div>
                <p style="font-size: 0.85rem; color: var(--text2); margin-bottom: 14px; line-height: 1.5;">
                    Guía completa para la evacuación en instituciones educativas. Incluye protocolos y rutas seguras.
                </p>
                <div style="display: flex; gap: 8px; flex-wrap: wrap; margin-bottom: 14px;">
                    <span style="background: rgba(249, 115, 22, 0.15); color: #f97316; font-size: 0.7rem; padding: 3px 10px; border-radius: 100px;">Evacuación</span>
                    <span style="background: rgba(0, 212, 176, 0.15); color: #00d4b0; font-size: 0.7rem; padding: 3px 10px; border-radius: 100px;">Escolar</span>
                </div>
                <div style="display: flex; gap: 8px;">
                    <a href="assets/media/guias/Evacuacion escolar.pdf" target="_blank" style="flex: 1; background: linear-gradient(135deg, #f97316, #ea6c0a); color: #fff; border: none; border-radius: 8px; padding: 8px 12px; font-size: 0.8rem; text-align: center; text-decoration: none; cursor: pointer; transition: opacity 0.2s;">
                        <svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg> Ver PDF
                    </a>
                    <a href="assets/media/guias/Evacuacion escolar.pdf" download style="background: var(--card2); color: var(--text1); border: 1px solid var(--border); border-radius: 8px; padding: 8px 12px; font-size: 0.8rem; text-decoration: none; cursor: pointer; transition: background 0.2s;">
                        <svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><line x1="12" y1="5" x2="12" y2="19"/><polyline points="19 12 12 19 5 12"/></svg>
                    </a>
                </div>
            </div>

            <!--   CARTILLA EVACUACIÓN ESCOLAR   -->
            <div class="resource-card" data-category="evacuacion" style="background: var(--card); border: 1px solid var(--border); border-radius: 16px; padding: 24px; transition: transform 0.2s, box-shadow 0.2s;">
                <div style="display: flex; align-items: center; gap: 14px; margin-bottom: 12px;">
                    <div style="font-size: 2.5rem;"></div>
                    <div>
                        <h3 style="font-size: 1rem; font-weight: 700; color: var(--text1); margin: 0;">Cartilla Evacuación Escolar</h3>
                        <span style="font-size: 0.75rem; color: var(--text3);">PDF · 2.1 MB</span>
                    </div>
                </div>
                <p style="font-size: 0.85rem; color: var(--text2); margin-bottom: 14px; line-height: 1.5;">
                    Cartilla ilustrada con pasos a seguir durante una evacuación escolar. Material educativo para niños y docentes.
                </p>
                <div style="display: flex; gap: 8px; flex-wrap: wrap; margin-bottom: 14px;">
                    <span style="background: rgba(249, 115, 22, 0.15); color: #f97316; font-size: 0.7rem; padding: 3px 10px; border-radius: 100px;">Evacuación</span>
                    <span style="background: rgba(0, 212, 176, 0.15); color: #00d4b0; font-size: 0.7rem; padding: 3px 10px; border-radius: 100px;">Cartilla</span>
                </div>
                <div style="display: flex; gap: 8px;">
                    <a href="assets/media/guias/Evacuacion escolarnCartilla-Guia-de-evacuacion-Escolar-1.pdf" target="_blank" style="flex: 1; background: linear-gradient(135deg, #f97316, #ea6c0a); color: #fff; border: none; border-radius: 8px; padding: 8px 12px; font-size: 0.8rem; text-align: center; text-decoration: none; cursor: pointer; transition: opacity 0.2s;">
                        <svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg> Ver PDF
                    </a>
                    <a href="assets/media/guias/Evacuacion escolarnCartilla-Guia-de-evacuacion-Escolar-1.pdf" download style="background: var(--card2); color: var(--text1); border: 1px solid var(--border); border-radius: 8px; padding: 8px 12px; font-size: 0.8rem; text-decoration: none; cursor: pointer; transition: background 0.2s;">
                        <svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><line x1="12" y1="5" x2="12" y2="19"/><polyline points="19 12 12 19 5 12"/></svg>
                    </a>
                </div>
            </div>

            <!--   MOCHILA EMERGENCIA 1   -->
            <div class="resource-card" data-category="mochila" style="background: var(--card); border: 1px solid var(--border); border-radius: 16px; padding: 24px; transition: transform 0.2s, box-shadow 0.2s;">
                <div style="display: flex; align-items: center; gap: 14px; margin-bottom: 12px;">
                    <div style="font-size: 2.5rem;"></div>
                    <div>
                        <h3 style="font-size: 1rem; font-weight: 700; color: var(--text1); margin: 0;">Mochila de Emergencia</h3>
                        <span style="font-size: 0.75rem; color: var(--text3);">PDF · 1.2 MB</span>
                    </div>
                </div>
                <p style="font-size: 0.85rem; color: var(--text2); margin-bottom: 14px; line-height: 1.5;">
                    Lista completa de suministros esenciales para tu mochila de emergencia. Agua, alimentos, herramientas y más.
                </p>
                <div style="display: flex; gap: 8px; flex-wrap: wrap; margin-bottom: 14px;">
                    <span style="background: rgba(0, 212, 176, 0.15); color: #00d4b0; font-size: 0.7rem; padding: 3px 10px; border-radius: 100px;">Mochila</span>
                    <span style="background: rgba(249, 115, 22, 0.15); color: #f97316; font-size: 0.7rem; padding: 3px 10px; border-radius: 100px;">Emergencia</span>
                </div>
                <div style="display: flex; gap: 8px;">
                    <a href="assets/media/guias/Mochila emergencia.pdf" target="_blank" style="flex: 1; background: linear-gradient(135deg, #f97316, #ea6c0a); color: #fff; border: none; border-radius: 8px; padding: 8px 12px; font-size: 0.8rem; text-align: center; text-decoration: none; cursor: pointer; transition: opacity 0.2s;">
                        <svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg> Ver PDF
                    </a>
                    <a href="assets/media/guias/Mochila emergencia.pdf" download style="background: var(--card2); color: var(--text1); border: 1px solid var(--border); border-radius: 8px; padding: 8px 12px; font-size: 0.8rem; text-decoration: none; cursor: pointer; transition: background 0.2s;">
                        <svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><line x1="12" y1="5" x2="12" y2="19"/><polyline points="19 12 12 19 5 12"/></svg>
                    </a>
                </div>
            </div>

            <!--   MOCHILA EMERGENCIA 2   -->
            <div class="resource-card" data-category="mochila" style="background: var(--card); border: 1px solid var(--border); border-radius: 16px; padding: 24px; transition: transform 0.2s, box-shadow 0.2s;">
                <div style="display: flex; align-items: center; gap: 14px; margin-bottom: 12px;">
                    <div style="font-size: 2.5rem;"></div>
                    <div>
                        <h3 style="font-size: 1rem; font-weight: 700; color: var(--text1); margin: 0;">Kit de Emergencia</h3>
                        <span style="font-size: 0.75rem; color: var(--text3);">PDF · 1.0 MB</span>
                    </div>
                </div>
                <p style="font-size: 0.85rem; color: var(--text2); margin-bottom: 14px; line-height: 1.5;">
                    Versión resumida del kit de emergencia con los elementos más importantes para sobrevivir 72 horas.
                </p>
                <div style="display: flex; gap: 8px; flex-wrap: wrap; margin-bottom: 14px;">
                    <span style="background: rgba(0, 212, 176, 0.15); color: #00d4b0; font-size: 0.7rem; padding: 3px 10px; border-radius: 100px;">Kit</span>
                    <span style="background: rgba(249, 115, 22, 0.15); color: #f97316; font-size: 0.7rem; padding: 3px 10px; border-radius: 100px;">72 horas</span>
                </div>
                <div style="display: flex; gap: 8px;">
                    <a href="assets/media/guias/Mochila emergencia2.pdf" target="_blank" style="flex: 1; background: linear-gradient(135deg, #f97316, #ea6c0a); color: #fff; border: none; border-radius: 8px; padding: 8px 12px; font-size: 0.8rem; text-align: center; text-decoration: none; cursor: pointer; transition: opacity 0.2s;">
                        <svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg> Ver PDF
                    </a>
                    <a href="assets/media/guias/Mochila emergencia2.pdf" download style="background: var(--card2); color: var(--text1); border: 1px solid var(--border); border-radius: 8px; padding: 8px 12px; font-size: 0.8rem; text-decoration: none; cursor: pointer; transition: background 0.2s;">
                        <svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><line x1="12" y1="5" x2="12" y2="19"/><polyline points="19 12 12 19 5 12"/></svg>
                    </a>
                </div>
            </div>

            <!--   PLAN FAMILIAR 1   -->
            <div class="resource-card" data-category="plan" style="background: var(--card); border: 1px solid var(--border); border-radius: 16px; padding: 24px; transition: transform 0.2s, box-shadow 0.2s;">
                <div style="display: flex; align-items: center; gap: 14px; margin-bottom: 12px;">
                    <div style="font-size: 2.5rem;"></div>
                    <div>
                        <h3 style="font-size: 1rem; font-weight: 700; color: var(--text1); margin: 0;">Plan Familiar de Emergencia</h3>
                        <span style="font-size: 0.75rem; color: var(--text3);">PDF · 1.5 MB</span>
                    </div>
                </div>
                <p style="font-size: 0.85rem; color: var(--text2); margin-bottom: 14px; line-height: 1.5;">
                    Guía para crear un plan familiar ante desastres. Incluye roles, puntos de reunión y comunicación.
                </p>
                <div style="display: flex; gap: 8px; flex-wrap: wrap; margin-bottom: 14px;">
                    <span style="background: rgba(45, 143, 255, 0.15); color: #2d8fff; font-size: 0.7rem; padding: 3px 10px; border-radius: 100px;">Plan Familiar</span>
                    <span style="background: rgba(249, 115, 22, 0.15); color: #f97316; font-size: 0.7rem; padding: 3px 10px; border-radius: 100px;">Emergencia</span>
                </div>
                <div style="display: flex; gap: 8px;">
                    <a href="assets/media/guias/Plan familiar.pdf" target="_blank" style="flex: 1; background: linear-gradient(135deg, #f97316, #ea6c0a); color: #fff; border: none; border-radius: 8px; padding: 8px 12px; font-size: 0.8rem; text-align: center; text-decoration: none; cursor: pointer; transition: opacity 0.2s;">
                        <svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg> Ver PDF
                    </a>
                    <a href="assets/media/guias/Plan familiar.pdf" download style="background: var(--card2); color: var(--text1); border: 1px solid var(--border); border-radius: 8px; padding: 8px 12px; font-size: 0.8rem; text-decoration: none; cursor: pointer; transition: background 0.2s;">
                        <svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><line x1="12" y1="5" x2="12" y2="19"/><polyline points="19 12 12 19 5 12"/></svg>
                    </a>
                </div>
            </div>

            <!--   PLAN FAMILIAR 2   -->
            <div class="resource-card" data-category="plan" style="background: var(--card); border: 1px solid var(--border); border-radius: 16px; padding: 24px; transition: transform 0.2s, box-shadow 0.2s;">
                <div style="display: flex; align-items: center; gap: 14px; margin-bottom: 12px;">
                    <div style="font-size: 2.5rem;"></div>
                    <div>
                        <h3 style="font-size: 1rem; font-weight: 700; color: var(--text1); margin: 0;">Plan Familiar - Versión 2</h3>
                        <span style="font-size: 0.75rem; color: var(--text3);">PDF · 1.3 MB</span>
                    </div>
                </div>
                <p style="font-size: 0.85rem; color: var(--text2); margin-bottom: 14px; line-height: 1.5;">
                    Complemento del plan familiar con checklist, contactos de emergencia y mapa de riesgos locales.
                </p>
                <div style="display: flex; gap: 8px; flex-wrap: wrap; margin-bottom: 14px;">
                    <span style="background: rgba(45, 143, 255, 0.15); color: #2d8fff; font-size: 0.7rem; padding: 3px 10px; border-radius: 100px;">Plan Familiar</span>
                    <span style="background: rgba(0, 212, 176, 0.15); color: #00d4b0; font-size: 0.7rem; padding: 3px 10px; border-radius: 100px;">Checklist</span>
                </div>
                <div style="display: flex; gap: 8px;">
                    <a href="assets/media/guias/plan familiar(1).pdf" target="_blank" style="flex: 1; background: linear-gradient(135deg, #f97316, #ea6c0a); color: #fff; border: none; border-radius: 8px; padding: 8px 12px; font-size: 0.8rem; text-align: center; text-decoration: none; cursor: pointer; transition: opacity 0.2s;">
                        <svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg> Ver PDF
                    </a>
                    <a href="assets/media/guias/plan familiar(1).pdf" download style="background: var(--card2); color: var(--text1); border: 1px solid var(--border); border-radius: 8px; padding: 8px 12px; font-size: 0.8rem; text-decoration: none; cursor: pointer; transition: background 0.2s;">
                        <svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><line x1="12" y1="5" x2="12" y2="19"/><polyline points="19 12 12 19 5 12"/></svg>
                    </a>
                </div>
            </div>

            <!--   PREPARACIÓN SISMOS   -->
            <div class="resource-card" data-category="sismo" style="background: var(--card); border: 1px solid var(--border); border-radius: 16px; padding: 24px; transition: transform 0.2s, box-shadow 0.2s;">
                <div style="display: flex; align-items: center; gap: 14px; margin-bottom: 12px;">
                    <div style="font-size: 2.5rem;"></div>
                    <div>
                        <h3 style="font-size: 1rem; font-weight: 700; color: var(--text1); margin: 0;">Preparación ante Sismos</h3>
                        <span style="font-size: 0.75rem; color: var(--text3);">PDF · 2.2 MB</span>
                    </div>
                </div>
                <p style="font-size: 0.85rem; color: var(--text2); margin-bottom: 14px; line-height: 1.5;">
                    Guía completa sobre cómo prepararse, actuar y recuperarse después de un sismo. Información del MARN y Cruz Roja.
                </p>
                <div style="display: flex; gap: 8px; flex-wrap: wrap; margin-bottom: 14px;">
                    <span style="background: rgba(249, 115, 22, 0.15); color: #f97316; font-size: 0.7rem; padding: 3px 10px; border-radius: 100px;">Sismos</span>
                    <span style="background: rgba(239, 68, 68, 0.15); color: #ef4444; font-size: 0.7rem; padding: 3px 10px; border-radius: 100px;">Prevención</span>
                </div>
                <div style="display: flex; gap: 8px;">
                    <a href="assets/media/guias/Preparacion ante sismos.pdf" target="_blank" style="flex: 1; background: linear-gradient(135deg, #f97316, #ea6c0a); color: #fff; border: none; border-radius: 8px; padding: 8px 12px; font-size: 0.8rem; text-align: center; text-decoration: none; cursor: pointer; transition: opacity 0.2s;">
                        <svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg> Ver PDF
                    </a>
                    <a href="assets/media/guias/Preparacion ante sismos.pdf" download style="background: var(--card2); color: var(--text1); border: 1px solid var(--border); border-radius: 8px; padding: 8px 12px; font-size: 0.8rem; text-decoration: none; cursor: pointer; transition: background 0.2s;">
                        <svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><line x1="12" y1="5" x2="12" y2="19"/><polyline points="19 12 12 19 5 12"/></svg>
                    </a>
                </div>
            </div>

            <!--   PROTOCOLO LLUVIAS 1   -->
            <div class="resource-card" data-category="lluvias" style="background: var(--card); border: 1px solid var(--border); border-radius: 16px; padding: 24px; transition: transform 0.2s, box-shadow 0.2s;">
                <div style="display: flex; align-items: center; gap: 14px; margin-bottom: 12px;">
                    <div style="font-size: 2.5rem;"></div>
                    <div>
                        <h3 style="font-size: 1rem; font-weight: 700; color: var(--text1); margin: 0;">Protocolo Lluvias</h3>
                        <span style="font-size: 0.75rem; color: var(--text3);">PDF · 1.6 MB</span>
                    </div>
                </div>
                <p style="font-size: 0.85rem; color: var(--text2); margin-bottom: 14px; line-height: 1.5;">
                    Protocolo de actuación ante lluvias intensas e inundaciones. Medidas de prevención y protección.
                </p>
                <div style="display: flex; gap: 8px; flex-wrap: wrap; margin-bottom: 14px;">
                    <span style="background: rgba(45, 143, 255, 0.15); color: #2d8fff; font-size: 0.7rem; padding: 3px 10px; border-radius: 100px;">Lluvias</span>
                    <span style="background: rgba(0, 212, 176, 0.15); color: #00d4b0; font-size: 0.7rem; padding: 3px 10px; border-radius: 100px;">Inundaciones</span>
                </div>
                <div style="display: flex; gap: 8px;">
                    <a href="assets/media/guias/Protocolo lluvias.pdf" target="_blank" style="flex: 1; background: linear-gradient(135deg, #f97316, #ea6c0a); color: #fff; border: none; border-radius: 8px; padding: 8px 12px; font-size: 0.8rem; text-align: center; text-decoration: none; cursor: pointer; transition: opacity 0.2s;">
                        <svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg> Ver PDF
                    </a>
                    <a href="assets/media/guias/Protocolo lluvias.pdf" download style="background: var(--card2); color: var(--text1); border: 1px solid var(--border); border-radius: 8px; padding: 8px 12px; font-size: 0.8rem; text-decoration: none; cursor: pointer; transition: background 0.2s;">
                        <svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><line x1="12" y1="5" x2="12" y2="19"/><polyline points="19 12 12 19 5 12"/></svg>
                    </a>
                </div>
            </div>

            <!--   PROTOCOLO LLUVIAS 2   -->
            <div class="resource-card" data-category="lluvias" style="background: var(--card); border: 1px solid var(--border); border-radius: 16px; padding: 24px; transition: transform 0.2s, box-shadow 0.2s;">
                <div style="display: flex; align-items: center; gap: 14px; margin-bottom: 12px;">
                    <div style="font-size: 2.5rem;"></div>
                    <div>
                        <h3 style="font-size: 1rem; font-weight: 700; color: var(--text1); margin: 0;">Protocolo Lluvias - V.2</h3>
                        <span style="font-size: 0.75rem; color: var(--text3);">PDF · 1.4 MB</span>
                    </div>
                </div>
                <p style="font-size: 0.85rem; color: var(--text2); margin-bottom: 14px; line-height: 1.5;">
                    Actualización del protocolo con nuevas medidas y recomendaciones para temporada de lluvias en El Salvador.
                </p>
                <div style="display: flex; gap: 8px; flex-wrap: wrap; margin-bottom: 14px;">
                    <span style="background: rgba(45, 143, 255, 0.15); color: #2d8fff; font-size: 0.7rem; padding: 3px 10px; border-radius: 100px;">Lluvias</span>
                    <span style="background: rgba(249, 115, 22, 0.15); color: #f97316; font-size: 0.7rem; padding: 3px 10px; border-radius: 100px;">Actualización</span>
                </div>
                <div style="display: flex; gap: 8px;">
                    <a href="assets/media/guias/Protocolo lluvias2.pdf" target="_blank" style="flex: 1; background: linear-gradient(135deg, #f97316, #ea6c0a); color: #fff; border: none; border-radius: 8px; padding: 8px 12px; font-size: 0.8rem; text-align: center; text-decoration: none; cursor: pointer; transition: opacity 0.2s;">
                        <svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg> Ver PDF
                    </a>
                    <a href="assets/media/guias/Protocolo lluvias2.pdf" download style="background: var(--card2); color: var(--text1); border: 1px solid var(--border); border-radius: 8px; padding: 8px 12px; font-size: 0.8rem; text-decoration: none; cursor: pointer; transition: background 0.2s;">
                        <svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:-0.15em" ><line x1="12" y1="5" x2="12" y2="19"/><polyline points="19 12 12 19 5 12"/></svg>
                    </a>
                </div>
            </div>

        </div>

        <!-- Contador de recursos -->
        <div style="text-align: center; margin-top: 30px; color: var(--text3); font-size: 0.85rem;">
            <span id="resourceCount">9</span> recursos educativos disponibles
        </div>

    </div>
</div>

<!-- JavaScript para filtros -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const filterBtns = document.querySelectorAll('.filter-btn');
    const cards = document.querySelectorAll('.resource-card');

    filterBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            filterBtns.forEach(b => {
                b.style.background = 'var(--card2)';
                b.style.color = 'var(--text1)';
                b.style.border = '1px solid var(--border)';
            });
            this.style.background = '#f97316';
            this.style.color = '#fff';
            this.style.border = 'none';

            const filter = this.dataset.filter;
            let visibleCount = 0;
            cards.forEach(card => {
                if (filter === 'all' || card.dataset.category === filter) {
                    card.style.display = 'block';
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });
            document.getElementById('resourceCount').textContent = visibleCount;
        });
    });

    const visible = document.querySelectorAll('.resource-card[style*="display: block"]');
    document.getElementById('resourceCount').textContent = visible.length || cards.length;
});
</script>

<style>
.resource-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 40px rgba(0, 0, 0, 0.3);
    border-color: rgba(249, 115, 22, 0.3);
}

.resource-card a:hover {
    opacity: 0.85;
}

.resource-card a[download]:hover {
    background: var(--card3);
}

.filter-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(249, 115, 22, 0.2);
}

.filter-btn.active {
    background: #f97316 !important;
    color: #fff !important;
    border: none !important;
}
</style>

<?php
$content = ob_get_clean();
require_once 'layout.php';
?>
