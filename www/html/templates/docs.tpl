
<div id="docs_sidenav" class="sidenav">
{* teacher only documentation content *}
{if $smarty.session.user}
    <a href="#">Teachers</a>
    <ul>
    {foreach from=$teacher_docs key=i item=row}	
        <li><a href="docs.php?doc_id={$row.doc_id}">{$row.name}</a></li>
    {/foreach}
    </ul>
{/if}  

    <a href="#">Students</a>
    <ul>
    {foreach from=$student_docs key=i item=row}
        <li><a href="docs.php?doc_id={$row.doc_id}">{$row.name}</a></li>
    {/foreach}
    </ul>
    
    <a href="#">Overdrive Class Methods</a>
    <ul>
    {foreach from=$overdrive_docs key=i item=row}
        <li><a href="docs.php?doc_id={$row.doc_id}">{$row.name}</a></li>
    {/foreach}
    </ul>
</div>

{if $doc_id}
    <div class="docs_main">
        <h1>{$doc.name}</h1>
        <br />
        <p>{$doc.content}</p>
        <br />
        <br />
        <br />
        <br />
    </div>
{else}
    <div class="docs_main">
        <h1>Documentation</h1>
        <br />
        <p>Use the links in the left side navigation to browse the docs.</p>
    </div>
{/if}

