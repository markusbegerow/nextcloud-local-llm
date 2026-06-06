<?php
script('local-llm', 'local-llm-nextcloud-main');
style('local-llm', 'style');
?>

<div id="app">
    <div id="app-navigation">
        <div class="app-navigation-new">
            <button id="new-chat-btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                <?php p($l->t('New Chat')); ?>
            </button>
        </div>
        <div class="app-navigation-personal">
            <ul id="conversation-nav-list"></ul>
        </div>
        <div id="app-settings">
            <div class="cw-settings-actions">
                <button class="cw-settings-btn" id="info-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                    <?php p($l->t('Info')); ?>
                </button>
                <button class="cw-settings-btn" id="settings-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
                    <?php p($l->t('Settings')); ?>
                </button>
            </div>
        </div>
    </div>

    <div id="app-content">
        <!-- Empty state -->
        <div id="no-chat-state">
            <div class="empty-content">
                <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" style="opacity:0.3"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                <h2><?php p($l->t('Local LLM Chat')); ?></h2>
                <p><?php p($l->t('Select a conversation or start a new chat to begin.')); ?></p>
                <button id="start-chat-btn" class="primary"><?php p($l->t('+ New Chat')); ?></button>
            </div>
        </div>

        <!-- Chat detail view -->
        <div id="chat-detail" style="display:none">
            <div class="llm-detail-wrapper">

                <div class="llm-detail-header">
                    <div class="llm-detail-title">
                        <h2 id="detail-chat-name"><?php p($l->t('New Conversation')); ?></h2>
                    </div>
                    <div class="llm-detail-actions">
                        <button id="detail-clear-btn"><?php p($l->t('Clear')); ?></button>
                        <button id="detail-delete-btn" class="cs-danger-btn"><?php p($l->t('Delete')); ?></button>
                    </div>
                </div>

                <div id="messages-container">
                    <div id="message-list"></div>
                    <div id="typing-indicator" style="display:none">
                        <div class="message assistant">
                            <div class="message-bubble">
                                <span class="typing-dot"></span>
                                <span class="typing-dot"></span>
                                <span class="typing-dot"></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="message-input-area">
                    <textarea id="message-input" placeholder="<?php p($l->t('Type a message… (Enter to send, Shift+Enter for new line)')); ?>" rows="3"></textarea>
                    <button id="send-btn" class="primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
                        <?php p($l->t('Send')); ?>
                    </button>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- Info Modal -->
<div id="info-modal" class="modal" style="display:none;">
    <div class="modal-content cw-about-card">
        <button id="info-close" class="cw-modal-close-btn" aria-label="<?php p($l->t('Close')); ?>">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
        </button>
        <div class="cw-about-header">
            <div class="cw-about-icon-box">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
            </div>
            <div class="cw-about-title">
                <h2><?php p($l->t('Local LLM Chat')); ?></h2>
                <div class="cw-about-subtitle-row">
                    <span><?php p($l->t('Privacy-first AI chat for Nextcloud')); ?></span>
                    <span class="cw-about-version-badge">v1.0</span>
                </div>
            </div>
        </div>
        <div class="cw-about-section">
            <p class="cw-section-heading"><?php p($l->t('Application Information')); ?></p>
            <dl class="cw-about-meta">
                <div><dt><?php p($l->t('Author')); ?></dt><dd>Markus Begerow</dd></div>
                <div><dt><?php p($l->t('Version')); ?></dt><dd>1.0</dd></div>
                <div><dt><?php p($l->t('License')); ?></dt><dd>GPL v3</dd></div>
            </dl>
        </div>
        <div class="cw-about-section">
            <p class="cw-section-heading"><?php p($l->t('Features')); ?></p>
            <ul class="cw-about-features">
                <li><?php p($l->t('All data stays on your server — no cloud APIs required')); ?></li>
                <li><?php p($l->t('Supports Ollama, LM Studio, vLLM and OpenAI-compatible endpoints')); ?></li>
                <li><?php p($l->t('Persistent conversation history')); ?></li>
                <li><?php p($l->t('API token encryption (AES-256)')); ?></li>
                <li><?php p($l->t('Rate limiting and input validation')); ?></li>
            </ul>
        </div>
        <div class="cw-about-section">
            <p class="cw-section-heading"><?php p($l->t('Links')); ?></p>
            <div class="cw-about-links">
                <a href="https://markus-begerow.de/linktree" target="_blank" rel="noopener" class="cw-about-link">
                    <span class="cw-about-link-icon"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg></span>
                    <div class="cw-about-link-body"><p><?php p($l->t('Website')); ?></p><p>markus-begerow.de/linktree</p></div>
                    <span class="cw-about-link-arrow">&#8599;</span>
                </a>
                <a href="https://github.com/markusbegerow/nextcloud-local-llm" target="_blank" rel="noopener" class="cw-about-link">
                    <span class="cw-about-link-icon"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22"/></svg></span>
                    <div class="cw-about-link-body"><p><?php p($l->t('GitHub')); ?></p><p>markusbegerow/nextcloud-local-llm</p></div>
                    <span class="cw-about-link-arrow">&#8599;</span>
                </a>
                <a href="https://www.paypal.com/paypalme/MarkusBegerow" target="_blank" rel="noopener" class="cw-about-link">
                    <span class="cw-about-link-icon"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8h1a4 4 0 0 1 0 8h-1"/><path d="M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"/><line x1="6" y1="1" x2="6" y2="4"/><line x1="10" y1="1" x2="10" y2="4"/><line x1="14" y1="1" x2="14" y2="4"/></svg></span>
                    <div class="cw-about-link-body"><p><?php p($l->t('Donate a coffee')); ?></p><p>paypal.me/MarkusBegerow</p></div>
                    <span class="cw-about-link-arrow">&#8599;</span>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- LLM Settings Modal (config management) -->
<div id="settings-modal" class="modal" style="display:none;">
    <div class="modal-content cw-settings-card llm-settings-wide">
        <button id="settings-close" class="cw-modal-close-btn" aria-label="<?php p($l->t('Close')); ?>">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
        </button>
        <h2 class="cw-settings-title"><?php p($l->t('Settings')); ?></h2>
        <p class="cw-form-hint" style="margin-bottom:16px"><?php p($l->t('Configure your local LLM endpoints (Ollama, LM Studio, vLLM, etc.)')); ?></p>

        <div id="config-list-container"></div>

        <div style="margin-top:12px;">
            <button id="add-config-btn" class="primary">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:middle;margin-right:4px"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                <?php p($l->t('Add Configuration')); ?>
            </button>
        </div>
    </div>
</div>

<!-- Add / Edit LLM Config Modal -->
<div id="config-modal" class="modal" style="display:none;">
    <div class="modal-content">
        <div class="modal-header">
            <h3 id="config-modal-title"><?php p($l->t('Add Configuration')); ?></h3>
            <button class="close-btn" id="close-config-modal">&times;</button>
        </div>
        <form id="config-form">
            <input type="hidden" id="config-id" value="">

            <div class="form-group">
                <label for="config-name"><?php p($l->t('Configuration Name')); ?></label>
                <input type="text" id="config-name" placeholder="<?php p($l->t('e.g. Ollama Llama3')); ?>" required>
            </div>

            <div class="form-group">
                <label for="config-api-url"><?php p($l->t('API URL')); ?></label>
                <input type="url" id="config-api-url" placeholder="http://localhost:11434/v1" required>
                <small><?php p($l->t('OpenAI-compatible endpoint. For Ollama: http://localhost:11434/v1')); ?></small>
            </div>

            <div class="form-group">
                <label for="config-api-token"><?php p($l->t('API Token')); ?></label>
                <input type="password" id="config-api-token" placeholder="<?php p($l->t('Leave empty if not required')); ?>">
                <small><?php p($l->t('Optional. Leave blank when editing to keep the existing token.')); ?></small>
            </div>

            <div class="form-group">
                <label for="config-model-name"><?php p($l->t('Model Name')); ?></label>
                <input type="text" id="config-model-name" placeholder="<?php p($l->t('e.g. llama3, mistral, phi3')); ?>" required>
            </div>

            <div class="form-group">
                <label for="config-temperature"><?php p($l->t('Temperature')); ?> (0 – 2)</label>
                <input type="number" id="config-temperature" min="0" max="2" step="0.1" value="0.7">
                <small><?php p($l->t('Controls creativity. Lower = more focused, higher = more creative.')); ?></small>
            </div>

            <div class="form-group">
                <label for="config-max-tokens"><?php p($l->t('Max Tokens')); ?> (128 – 32768)</label>
                <input type="number" id="config-max-tokens" min="128" max="32768" step="128" value="2048">
            </div>

            <div class="form-group">
                <label for="config-system-prompt"><?php p($l->t('System Prompt')); ?></label>
                <textarea id="config-system-prompt" rows="4" placeholder="<?php p($l->t('You are a helpful AI assistant...')); ?>"></textarea>
                <small><?php p($l->t('Optional. Leave empty to use the default system prompt.')); ?></small>
            </div>

            <div class="form-group">
                <label>
                    <input type="checkbox" id="config-is-default">
                    <?php p($l->t('Set as default configuration')); ?>
                </label>
            </div>

            <div class="form-actions">
                <button type="button" id="test-config-btn"><?php p($l->t('Test Connection')); ?></button>
                <button type="submit" class="primary"><?php p($l->t('Save')); ?></button>
                <button type="button" id="cancel-config-btn"><?php p($l->t('Cancel')); ?></button>
            </div>
        </form>
    </div>
</div>
