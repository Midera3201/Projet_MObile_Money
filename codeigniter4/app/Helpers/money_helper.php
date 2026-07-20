<?php

function format_argent($montant) {
    return number_format($montant, 0, ',', '.') . ' Ar';
}