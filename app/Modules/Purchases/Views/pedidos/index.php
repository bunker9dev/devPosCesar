 <div class="module-header">
     <?php if ($canCreate): ?>
         <a href="<?= BASE_URL ?>/pedidos/create" class="btn-primary">+ Crear pedido</a>
     <?php endif; ?>
 </div>

 <div class="table-container">
     <table id="tablaPedidos" class="table-main display">
         <thead>
             <tr>
                 <th></th>
                 <th>#</th>
                 <th>Consecutivo</th>
                 <th>Proveedor</th>
                 <th>Fecha solicitud</th>
                 <th>Items</th>
                 <th>Estado</th>
                 <th>Acciones</th>
             </tr>
         </thead>
         <tbody>
             <?php foreach ($pedidos as $i => $p): ?>
                 <?php $eliminado = $p['deleted_at'] !== null; ?>
                 <tr data-id="<?= $p['id'] ?>" class="<?= $eliminado ? 'deleted' : ($p['vencido'] ? 'pedido-vencido' : '') ?>">
                     <td></td>
                     <td data-label="#"><?= $i + 1 ?></td>
                     <td data-label="Consecutivo">
                         <a href="<?= BASE_URL ?>/pedidos/show?id=<?= $p['id'] ?>">
                             <?= htmlspecialchars($p['consecutivo']) ?>
                         </a>
                         <?php if ($p['vencido']): ?>
                             <span class="badge warning">⚠️ <?= $p['dias_abierto'] ?>d</span>
                         <?php endif; ?>
                     </td>
                     <td data-label="Proveedor"><?= htmlspecialchars($p['proveedor_nombre']) ?></td>
                     <td data-label="Fecha solicitud"><?= htmlspecialchars($p['fecha_solicitud']) ?></td>
                     <td data-label="Items"><?= $p['cantidad_items'] ?></td>
                     <td data-label="Estado">
                         <span class="badge estado-<?= $p['estado'] ?>"><?= ucfirst($p['estado']) ?></span>
                     </td>
                     <td data-label="Acciones">
                         <div class="actions">
                             <?php if (!$eliminado): ?>
                                 <a href="<?= BASE_URL ?>/pedidos/show?id=<?= $p['id'] ?>" class="btn-action edit">Ver</a>
                                 <?php if ($canEdit && $p['estado'] === 'borrador'): ?>
                                     <a href="<?= BASE_URL ?>/pedidos/edit?id=<?= $p['id'] ?>" class="btn-action edit">Editar</a>
                                 <?php endif; ?>
                                 <?php if ($canDelete && $p['estado'] === 'borrador'): ?>
                                     <button class="btn-action delete btn-delete-pedido"
                                         data-id="<?= $p['id'] ?>"
                                         data-consecutivo="<?= htmlspecialchars($p['consecutivo']) ?>">
                                         Eliminar
                                     </button>
                                 <?php endif; ?>
                             <?php elseif ($canRestore): ?>
                                 <button class="btn-action restore btn-restore"
                                     data-id="<?= $p['id'] ?>"
                                     data-url="<?= BASE_URL ?>/pedidos/restore">
                                     Restaurar
                                 </button>
                             <?php endif; ?>
                         </div>
                     </td>
                 </tr>
             <?php endforeach; ?>
         </tbody>
     </table>
 </div>

 <?php
    // Botón de edición global solo si existe el último pedido en la iteración y es borrador
    if (!empty($p) && $canEdit && $p['estado'] === 'borrador'): ?>
     <a href="<?= BASE_URL ?>/pedidos/edit?id=<?= $p['id'] ?>" class="btn-action edit">Editar</a>
 <?php endif; ?>

 <?php require __DIR__ . '/modals.php'; ?>

 <script type="module" src="<?= BASE_URL ?>/assets/js/pages/pedidos-index.js"></script>