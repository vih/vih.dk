
    <table summary="<?php e(__('Contact information')); ?>">
        <caption><?php e(__('Contact information')); ?></caption>
        <tr>
            <th><?php e(__('Number')); ?></th>
            <td><?php e($contact['number']); ?></td>
        </tr>
        <tr>
            <th><?php e(__('Name')); ?></th>
            <td><?php e($contact['name']); ?></td>
        </tr>
        <tr>
            <th><?php e(__('Address')); ?></th>
            <td>
                <?php if(!empty($contact['address'])): ?>
                    <?php e($contact['address']); ?>
                <?php else: ?>
                    IKKE INDSKREVET
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <th><?php e(__('Zip code and city')); ?></th>
            <td>
                <?php if(!empty($contact['postcode'])): ?>
                    <?php e($contact['postcode']); ?>  <?php e($contact['city']); ?>
                <?php else: ?>
                    IKKE INDSKREVET
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <th><?php e(__('Phone')); ?></th>
            <td><?php e($contact['phone']); ?></td>
        </tr>
        <tr>
            <th><?php e(__('E-mail')); ?></th>
            <td><?php e($contact['email']); ?></td>
        </tr>
    </table>

    <p><a href="<?php e(url('edit')); ?>"><?php e(__('Edit')); ?></a></p>
