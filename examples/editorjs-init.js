import EditorJS from '@editorjs/editorjs';
import Header from '@editorjs/header';
import List from '@editorjs/list';

let editorjsToolsScoped = [];
if (typeof editorjsTools !== 'undefined') {
  // eslint-disable-next-line no-undef
  editorjsToolsScoped = editorjsTools;
}

editorjsToolsScoped.Header = Header;
editorjsToolsScoped.List = List;

let editorjsConfigsScoped = [];
if (typeof editorjsConfigs !== 'undefined') {
  // eslint-disable-next-line no-undef
  editorjsConfigsScoped = editorjsConfigs;
}

const editors = [];

async function editorjsSave(holderId) {
  const editorHolder = document.getElementById(holderId);
  const editorInput = document.getElementById(editorHolder.getAttribute('data-input-id'));
  const editor = editors[holderId];

  const savePromise = editor.save().then((outputData) => {
    editorInput.value = JSON.stringify(outputData);
  });

  await savePromise;
}

if (typeof editorjsConfigsScoped !== 'undefined') {
  editorjsConfigsScoped.forEach((config) => {
    if (typeof config.tools !== 'undefined') {
      // set tool classes
      Object.keys(config.tools).forEach((toolName) => {
        // eslint-disable-next-line no-param-reassign
        config.tools[toolName].class = editorjsToolsScoped[config.tools[toolName].className];
      });
    }

    // eslint-disable-next-line no-param-reassign,func-names
    config.onChange = async function () {
      await editorjsSave(this.holder);
    };

    const editorHolder = document.getElementById(config.holder);
    const editorForm = editorHolder.closest('form');

    if (!editorForm.hasEditorjsListener) {
      editorForm.addEventListener('submit', (event) => {
        event.preventDefault();

        const form = event.target;
        form.hasEditorjsListener = true;

        // save all editors in form
        const editorHolders = form.querySelectorAll('.editorjs-holder');
        const savePromises = [];
        editorHolders.forEach((holder) => {
          savePromises.push(editorjsSave(holder.id));
        });

        Promise.all(savePromises).then(() => {
          form.submit();
        });
      });
    }

    editors[config.holder] = new EditorJS(config);
  });
}
