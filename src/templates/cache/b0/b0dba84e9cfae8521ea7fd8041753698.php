<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* add-magazine.html */
class __TwigTemplate_580baaf1b6676a27f9444102e3dad49e extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 1
        echo "<style>
    form {
        display: flex;
        flex-direction: column;
    
    }
</style>

<h1>Kaine Magazine mehr ;)</h1>

<form class=\"js-add-magazine-form\" method=\"post\">
    ";
        // line 12
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["magazines"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["magazine"]) {
            // line 13
            echo "        <label>
            <input type=\"radio\" name=\"magazine\" value=\"";
            // line 14
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["magazine"], "magazine", [], "any", false, false, false, 14), "html", null, true);
            echo "\">";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["magazine"], "magazine", [], "any", false, false, false, 14), "html", null, true);
            echo "
        </label>
    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['magazine'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 17
        echo "    <label>
        <input type=\"radio\" name=\"magazine\" class=\"js-new-magazine-radio\" value=\"\"><input type=\"text\" class=\"js-new-magazine-text\">
    </label>
    <label>
        Datum: <br>
        <input type=\"date\" name=\"issue_date\">
    </label>
    <label>
        Titel: <br>
        <input type=\"text\" name=\"issue_title\">
    </label>
    <button type=\"submit\">Speichern</button>
</form>

<script>
    (() => {
        const newMagazineText = document.querySelector('.js-new-magazine-text')
        const newMagazineRadio = document.querySelector('.js-new-magazine-radio')
        newMagazineText.addEventListener('keyup', () => {
            newMagazineRadio.value = newMagazineText.value
            newMagazineRadio.checked = true
        })

        const form = document.querySelector('.js-add-magazine-form')
        form.addEventListener('submit', evt => {
            const formData = new FormData(form)
            evt.preventDefault()

            const xhr = new XMLHttpRequest()
            xhr.open('POST', '/kai/add')
            xhr.send(formData)
        })
    })()
</script>";
    }

    public function getTemplateName()
    {
        return "add-magazine.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  68 => 17,  57 => 14,  54 => 13,  50 => 12,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "add-magazine.html", "C:\\Development\\kai\\src\\templates\\src\\add-magazine.html");
    }
}
