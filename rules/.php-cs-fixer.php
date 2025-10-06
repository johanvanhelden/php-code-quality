<?php

declare(strict_types=1);

use PhpCsFixer\Config;
use PhpCsFixer\Runner\Parallel\ParallelConfig;

const PARALLEL_PROCESSES = 8;
const PARALLEL_FILES_PER_PROCESS = 20;

return new Config()
    ->setParallelConfig(new ParallelConfig(
        maxProcesses: PARALLEL_PROCESSES,
        filesPerProcess: PARALLEL_FILES_PER_PROCESS,
    ))
    ->setRiskyAllowed(true)
    ->setRules([
        '@PSR12' => true,

        'array_syntax'                             => ['syntax' => 'short'],
        'assign_null_coalescing_to_coalesce_equal' => true,
        'blank_line_after_opening_tag'             => true,
        'blank_line_before_statement'              => ['statements' => ['return']],
        'binary_operator_spaces'                   => [
            'default'   => 'single_space',
            'operators' => [
                '=>' => 'align_single_space_minimal',
            ],
        ],
        'cast_spaces'                            => true,
        'class_attributes_separation'            => ['elements' => ['method' => 'one']],
        'concat_space'                           => ['spacing' => 'one'],
        'declare_equal_normalize'                => true,
        'declare_strict_types'                   => true,
        'function_typehint_space'                => true,
        'include'                                => true,
        'increment_style'                        => ['style' => 'post'],
        'lowercase_cast'                         => true,
        'modernize_strpos'                       => true,
        'multiline_whitespace_before_semicolons' => true,
        'native_function_casing'                 => true,
        'new_with_parentheses'                   => false,
        'no_blank_lines_after_class_opening'     => true,
        'no_blank_lines_after_phpdoc'            => true,
        'no_empty_phpdoc'                        => true,
        'no_empty_statement'                     => true,
        'no_extra_blank_lines'                   => [
            'tokens' => [
                'curly_brace_block',
                'extra',
                'parenthesis_brace_block',
                'square_brace_block',
                'throw',
                'use',
            ],
        ],
        'no_leading_namespace_whitespace'             => true,
        'no_mixed_echo_print'                         => ['use' => 'echo'],
        'no_multiline_whitespace_around_double_arrow' => true,
        'no_short_bool_cast'                          => true,
        'no_singleline_whitespace_before_semicolons'  => true,
        'no_spaces_around_offset'                     => true,
        'no_trailing_comma_in_singleline'             => true,
        'no_unneeded_control_parentheses'             => true,
        'no_unused_imports'                           => true,
        'no_useless_else'                             => true,
        'no_useless_return'                           => true,
        'no_whitespace_before_comma_in_array'         => true,
        'no_whitespace_in_blank_line'                 => true,
        'normalize_index_brace'                       => true,
        'object_operator_without_whitespace'          => true,
        'ordered_imports'                             => true,
        'phpdoc_align'                                => true,
        'phpdoc_annotation_without_dot'               => true,
        'phpdoc_indent'                               => true,
        'phpdoc_no_access'                            => true,
        'phpdoc_no_alias_tag'                         => true,
        'phpdoc_no_empty_return'                      => false,
        'phpdoc_no_package'                           => true,
        'phpdoc_no_useless_inheritdoc'                => true,
        'phpdoc_return_self_reference'                => true,
        'phpdoc_scalar'                               => true,
        'phpdoc_separation'                           => [
            'groups' => [
                // general
                [
                    'deprecated',
                    'internal',
                    'todo',
                ],
                // doc blocks, phpstan types
                [
                    'extends',
                    'method',
                    'mixin',
                    'param',
                    'param-out',
                    'phpstan-extends',
                    'phpstan-param',
                    'phpstan-return',
                    'phpstan-template',
                    'phpstan-var',
                    'property',
                    'property-read',
                    'property-write',
                    'return',
                    'template',
                    'var',
                ],
                // phpunit specific
                [
                    'covers',
                    'coversDefaultClass',
                    'coversNothing',
                    'dataProvider',
                    'depends',
                    'requires',
                    'test',
                ],
            ],
        ],
        'phpdoc_single_line_var_spacing'     => true,
        'phpdoc_summary'                     => true,
        'phpdoc_to_comment'                  => false,
        'phpdoc_trim'                        => true,
        'phpdoc_types'                       => true,
        'phpdoc_var_without_name'            => false,
        'pow_to_exponentiation'              => true,
        'psr_autoloading'                    => true,
        'self_accessor'                      => true,
        'short_scalar_cast'                  => true,
        'simplified_null_return'             => true,
        'single_class_element_per_statement' => true,
        'single_line_comment_style'          => true,
        'single_quote'                       => true,
        'space_after_semicolon'              => true,
        'standardize_not_equals'             => true,
        'ternary_to_null_coalescing'         => true,
        'trailing_comma_in_multiline'        => ['elements' => ['arrays']],
        'trim_array_spaces'                  => true,
        'type_declaration_spaces'            => ['elements' => ['function']],
        'new_expression_parentheses'         => [
            'use_parentheses' => false,
        ],
        'void_return'                        => true,
        'whitespace_after_comma_in_array'    => true,
    ])
    ->setLineEnding("\n");
